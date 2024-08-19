<?php

require_once("../../../vendor/autoload.php");
require_once("../../../class/Encrypt.php");
// require_once("../../../class/class.ProgressBar.php");
require_once("../../../dbconf.php");

date_default_timezone_set('Asia/Bangkok');

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use PureCloudPlatform\Client\V2\Configuration;
use PureCloudPlatform\Client\V2\Api\RecordingApi;
use GuzzleHttp\Client;

$env = "mypurecloud.jp";
$voice_limit = "100";
$dir_temp = "temp";
$dir_export = "export";

/*
status
0 = sendpost
1 = receiveurl
2 = not found
*/

$config = new \Doctrine\DBAL\Configuration();
$connectionParams = array(
    'dbname' => $db_name,
    'user' => $db_username,
    'password' => $db_password,
    'host' => $db_server_ip,
    // 'port' => 32032,
    'driver' => 'pdo_mysql',
    'charset'       =>  'UTF8'
);
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);


if (isset($_GET['action'])) {

    switch ($_GET['action']) {

        case "requestvoice":
            requestvoice();
            break;
        case "getvoice":
            getvoice();
            break;
        case "mergefile":
            mergefile();
            break;

    }
}

function apiInstance()
{
    global $env;
    try {

        $provider = new GenericProvider([
            'clientId' => trim((getenv("GENE_CLIENTID")) ? getenv("GENE_CLIENTID") : GENE_CLIENTID),
            // The client ID assigned to you by the provider
            'clientSecret' => trim((getenv("GENE_CLIENTSECRET")) ? getenv("GENE_CLIENTSECRET") : GENE_CLIENTSECRET),
            // The client password assigned to you by the provider
            // 'redirectUri'             => 'https://my.example.com/your-redirect-url/',
            'urlAuthorize' => 'https://service.example.com/authorize',
            'urlAccessToken' => "https://login.$env/oauth/token",
            'urlResourceOwnerDetails' => 'https://service.example.com/resource'
        ]);
        // Try to get an access token using the client credentials grant.
        $accessToken = $provider->getAccessToken('client_credentials');

    } catch (IdentityProviderException $e) {

        // Failed to get the access token
        exit($e->getMessage());

    }

    $config = Configuration::getDefaultConfiguration()->setAccessToken($accessToken);
    $config->setHost("https://api.$env");

    $apiInstance = new RecordingApi(
        // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
        // This is optional, `GuzzleHttp\Client` will be used as default.
        new Client(),
        $config
    );
    return $apiInstance;
}

function path_put_contents($filePath, $contents, $flags = 0)
{

    if (!is_dir($dir = implode('/', explode('/', $filePath, -1))))
        mkdir($dir, 0777, true);
    return file_put_contents($filePath, $contents, $flags);
}

function merge_file($dest, $files){
    $temp_file = "";
    if(!is_array($files)){
        return path_put_contents($dest, file_get_contents($files));
    } 
    foreach($files as $file){
        $temp_file .= file_get_contents($file);
    }
    return path_put_contents($dest, $temp_file); 
}

function requestvoice()
{
    global $voice_limit, $conn;
    $startdate = isset($_GET["startdate"]) ? $_GET["startdate"] : "20231001";
    $enddate = isset($_GET["enddate"]) ? $_GET["enddate"] : "20231031";


    $sql = "SELECT distinct ta.id,tct.voice_id FROM t_aig_app ta 
LEFT JOIN t_call_trans tct ON ta.calllist_id=tct.calllist_id
LEFT JOIN tg_voice_gen tgb on tct.voice_id=tgb.voice_id and ta.id=tgb.app_id
WHERE (tct.voice_id is not null and tct.voice_id<>'')
and (tgb.status is null)
and ta.AppStatus = ? and (Approved_Date>=? and Approved_Date<=?) ORDER BY ta.id asc,tct.create_date asc";

    $stmt = $conn->prepare($sql); // Simple, but has several drawbacks
    $stmt->bindValue(1, "QC_Approved");
    $stmt->bindValue(2, $startdate);
    $stmt->bindValue(3, $enddate);
    $stmt->execute();
    $voices = $stmt->fetchAll();
    $split_voice = array_chunk($voices, 100);

    $apiInstance = apiInstance();
    $seq = array();
    if (ob_get_level() == 0)
        ob_start();
    // $stmt2 = $conn->query("select * from tg_voice_gen");
    try {
        foreach ($split_voice as $s_voice) {

            $jobsubmit = new \PureCloudPlatform\Client\V2\Model\BatchDownloadJobSubmission();
            $voice_list = array_map(function ($a) {
                $downloadlist = new \PureCloudPlatform\Client\V2\Model\BatchDownloadRequest();
                $downloadlist->setConversationId($a["voice_id"]);
                return $downloadlist;
            }, $s_voice);
            $jobsubmit->setBatchDownloadRequestList($voice_list);
            $result = $apiInstance->postRecordingBatchrequests($jobsubmit);
            $jobid = $result->getId();

            // $jobid = "caad39b1-5c8c-4269-8a28-a9f2d102896f";
            $created = new \Datetime('now');
            $create_d = $created->format('Y-m-d H:i:s');
            foreach ($s_voice as $voice) {
                $voice_id = $voice["voice_id"];
                $app_id = $voice["id"];
                if(!isset($seq[$app_id]))
                    $seq[$app_id] = 0;
                else 
                    $seq[$app_id]++;
                $new_array = array(
                    "voice_id"=>$voice_id,
                    "job_id"=>$jobid,
                    "app_id"=>$app_id,
                    "seq"=>$seq[$app_id],
                    "status"=>0,
                    "create_date"=>$create_d
                );
                echo "$voice_id : $jobid : $app_id <br>";
                ob_flush();
                flush();
                $conn->insert('tg_voice_gen', $new_array);
            }

        }
        ob_end_flush();
    } catch (Exception $e) {
        exit($e->getMessage());
    }
}

function getvoice()
{
    global $conn,$dir_temp;
    $stmt = $conn->query("select distinct job_id,voice_id,app_id from tg_voice_gen where status=0");
    $alldata = $conn->fetchAll("select distinct job_id from tg_voice_gen where status=0");
    $apiInstance = apiInstance();
    $dir = $dir_temp;
    $jobs = array_unique(array_keys(array_column($alldata, null, "job_id")));
    // $jobs = array(
    //     "45e4e8ff-3fce-4c2f-acb2-f6f9569fdc0f",
    //     "14797d30-9d6c-4db5-a22b-72994a4bc2e7",
    //     "33f739da-99d4-49bc-8e75-251ae89ad52e",
    //     "27170545-f9d2-4eaa-a96d-5054d4fb50c0");
    if (ob_get_level() == 0)
        ob_start();

    $voice_list = [];
    try {
        foreach ($jobs as $row) {
            $jobid = $row;
            $result = $apiInstance->getRecordingBatchrequest($jobid);
            $temp_voice = array_column(array_map(function ($a) use ($jobid) {
                $data = array();
                $url = $a->getResultUrl();
                $err = $a->getErrorMsg();
                if (!$url && !$err) {
                    return false;
                }
                $data["key"] = $a->getConversationId() . ":" . $jobid;
                $data["data"] = $a;
                return $data;
            }, $result->getResults()), null, "key");
            $voice_list = array_merge($voice_list, $temp_voice);
        }
        $i = 0;
        while ($row = $stmt->fetch()) {
            $i++;
            $voice_id = $row["voice_id"];
            $job_id = $row["job_id"];
            $app_id = $row["app_id"];
            // $test = "$voice_id:$job_id:$app_id";
            $index = "$voice_id:$job_id";
            $voice = $voice_list[$index]["data"];
            $url = $voice->getResultUrl();
            $file_name = "$dir/$app_id/" . $voice->getRecordingId() . ".opus";
            $updatedate = new \Datetime('now');
            $update_d = $updatedate->format('Y-m-d H:i:s');
            if ($url) {
                $updatedata = array("update_date" => $update_d, "status" => 1, "url" => $url, "path" => $file_name);
                $where = array("voice_id" => $voice_id, "job_id" => $job_id, "app_id" => $app_id);
                ob_flush();
                flush();
                $conn->update('tg_voice_gen', $updatedata, $where);
                if (file_exists($file_name)) {
                    echo "$file_name $i Have. <br>";
                    continue;
                }
                if (path_put_contents($file_name, file_get_contents($url))) {
                    echo "$file_name $i <br>";
                }
            } else {
                $updatedata = array("update_date" => $update_d, "status" => 2);
                $where = array("voice_id" => $voice_id, "job_id" => $job_id, "app_id" => $app_id);
                echo $voice->getErrorMsg() . " $i<br>";
                ob_flush();
                flush();
                $conn->update('tg_voice_gen', $updatedata, $where);
            }
        }
        ob_end_flush();
    } catch (Exception $e) {
        exit($e->getMessage());
    }
}

function mergefile()
{
    global $conn,$dir_export;
    $startdate = isset($_GET["startdate"]) ? $_GET["startdate"] : "20231001";
    $enddate = isset($_GET["enddate"]) ? $_GET["enddate"] : "20231031";

    $dir = $dir_export;


    $sql = "SELECT ta.id,tc.plancode,ta.ProposalNumber,ta.FIRSTNAME,ta.LASTNAME,ta.Approved_Date,tgb.path,tag.first_name as agent_fname,tag.last_name as agent_lname,tqc.first_name as qc_fname,tqc.last_name as qc_lname FROM t_aig_app ta 
    LEFT JOIN t_campaign tc on ta.campaign_id=tc.campaign_id
    LEFT JOIN tg_voice_gen tgb on ta.id=tgb.app_id
    LEFT JOIN t_agents tag on ta.agent_id=tag.agent_id
    LEFT JOIN (SELECT distinct tah.AppId,ta.first_name,ta.last_name FROM t_aig_app_history tah LEFT JOIN t_agents ta ON tah.update_by=ta.agent_id
WHERE ta.level_id=3 AND tah.AppID IS NOT NULL AND tah.AppID<>'') tqc on ta.id=tqc.AppId
    WHERE (tgb.status = 1)
    and ta.AppStatus = ? and (Approved_Date>=? and Approved_Date<=?) ORDER BY ta.id,tgb.seq";


    $stmt = $conn->prepare($sql); // Simple, but has several drawbacks
    $stmt->bindValue(1, "QC_Approved");
    $stmt->bindValue(2, $startdate);
    $stmt->bindValue(3, $enddate);
    $stmt->execute();
    $apps = array();
    while ($row = $stmt->fetch()) {
        $appid = trim($row["plancode"].$row["ProposalNumber"]);
        $cus_name = trim($row["FIRSTNAME"]." ".Encryption::decrypt($row["LASTNAME"]));
        $approvedate = trim($row["Approved_Date"]);
        $agent_name = trim($row["agent_fname"]." ".$row["agent_lname"]);
        $qc_name = trim($row["qc_fname"]." ".$row["qc_lname"]);
        $path = trim($row["path"]);
        $file_name = "$dir/$startdate-$enddate/$appid-$cus_name-$approvedate-$agent_name-$qc_name"."_OK.opus";
        $apps[$appid]["filename"] = $file_name;
        $apps[$appid]["voice"][] = $path;
        // if(!isset($app[$appid]["voice"])){
        //     $apps[$appid]["voice"] = array($path);
        // } else {
        //     array_push($apps[$appid]["voice"],$path);
        // }
    }
    //merge
    $i=0;
    if (ob_get_level() == 0)
        ob_start();
    foreach($apps as $app){
        $i++;
        $filename = $app["filename"];
        $voice = $app["voice"];
        if (file_exists($filename)) {
            echo "$filename $i Have. <br>";
            continue;
        }
        ob_flush();
        flush();
        if (merge_file($filename, $voice)) {
            echo "$filename $i <br>";
        }
        // $filename = $app
        // merge_file
    }
    ob_end_flush();
}
?>