<?php
require_once ($_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php");
require_once ($_SERVER['DOCUMENT_ROOT']."/dbconf.php");
require_once ($_SERVER['DOCUMENT_ROOT']."/wlog.php");
class OutboundGenesys {

    private $env = "mypurecloud.jp";

    private $provider;
    // Properties
    private $accessToken;

    private $contactListId = "0db0c348-303c-4cc4-ad51-16df95283e24";

    private $version = "v2";

    public function setcontactListId($contactListId)
    {
        $this->contactListId = $contactListId;
    }

    public function setEnv($env)
    {
        $this->env = $env;
    }

    public function __construct(){
        try {

            $this->provider = new \League\OAuth2\Client\Provider\GenericProvider([
                'clientId'                => trim((getenv("GENE_CLIENTID"))?getenv("GENE_CLIENTID"):GENE_CLIENTID),    // The client ID assigned to you by the provider
                'clientSecret'            => trim((getenv("GENE_CLIENTSECRET"))?getenv("GENE_CLIENTSECRET"):GENE_CLIENTSECRET),    // The client password assigned to you by the provider
                // 'redirectUri'             => 'https://my.example.com/your-redirect-url/',
                'urlAuthorize'            => 'https://service.example.com/authorize',
                'urlAccessToken'          => "https://login.$this->env/oauth/token",
                'urlResourceOwnerDetails' => 'https://service.example.com/resource'
            ]);
            // Try to get an access token using the client credentials grant.
            $this->accessToken = $this->provider->getAccessToken('client_credentials');
        
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
        
            // Failed to get the access token
            exit($e->getMessage());
        
        }
    }

    private function curlData($url, $method="GET",$data=null){

        $curl = curl_init();

        // $curl_data = array(
        //     CURLOPT_URL => $url,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => $method,
        //     CURLOPT_HTTPHEADER => array(
        //         "Accept: application/json",
        //         "Content-Type: application/json",
        //         "authorization: Bearer $this->accessToken"
        //     ),
        // );

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Accept: application/json",
            "Content-Type: application/json",
            "authorization: Bearer $this->accessToken"
        ));

        wlog( "[genesys][log]  url : ".$url );
        wlog( "[genesys][log]  data : ".print_r($data,true) );

        if($data) curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        // var_dump(json_encode($data));
        // exit();

        // if($data) $curl_data = array_merge($curl_data,[CURLOPT_POSTFIELDS=>json_encode($data)]);

        // curl_setopt_array($curl, $curl_data);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);
        
        if (isset($error_msg)) {
            return $error_msg;
        }
        wlog( "[genesys][log]  return data : ".$response );
        return json_decode($response);

    }

    public function getContactlists(){
        $url = "https://api.$this->env/api/$this->version/outbound/contactlists?includeImportStatus=false&includeSize=false&pageSize=25&pageNumber=1&allowEmptyResult=false&filterType=Prefix";
        $method = "GET";
        return $this->curlData($url, $method);
    }

    public function getContactlistData(){
        $url = "https://api.$this->env/api/$this->version/outbound/contactlists/$this->contactListId?includeImportStatus=false&includeSize=false";
        $method = "GET";
        return $this->curlData($url, $method);
    }

    public function clearContactlist(){
        $url = "https://api.$this->env/api/$this->version/outbound/contactlists/$this->contactListId/clear";
        $method = "POST";
        return $this->curlData($url, $method);
    }

    public function addContactlist($data){
        if(!$data) return false;
        $url = "https://api.$this->env/api/$this->version/outbound/contactlists/$this->contactListId/contacts";
        $method = "POST";
        return $this->curlData($url, $method, $data);
    }

    public function getContactData($contactId){
        if(!$contactId) return false;
        $url = "https://api.$this->env/api/$this->version/outbound/contactlists/$this->contactListId/contacts/$contactId";
        $method = "GET";
        return $this->curlData($url, $method);
    }

    public function getWrapupCodes($queueId){
        if(!$queueId) return false;
        $url = "https://api.$this->env/api/$this->version/routing/queues/$queueId/wrapupcodes";
        $method = "GET";
        return $this->curlData($url, $method);
    }

    public function getConversationsCall($conversationId){
        if(!$conversationId) return false;
        $url = "https://api.$this->env/api/$this->version/conversations/calls/$conversationId";
        $method = "GET";
        return $this->curlData($url, $method);
    }

    public function patchParticipants($conversationId, $participantId, $data){
        if(!$conversationId) return false;
        $url = "https://api.$this->env/api/$this->version/conversations/$conversationId/participants/$participantId";
        $method = "PATCH";
        return $this->curlData($url, $method, $data);
    }

    public function postCallbacks($conversationId, $participantId, $data){
        if(!$conversationId) return false;
        $url = "https://api.$this->env/api/$this->version/conversations/$conversationId/participants/$participantId/callbacks";
        $method = "POST";
        return $this->curlData($url, $method, $data);
    }

    public function postCallbacks_new($data){
        $url = "https://api.$this->env/api/$this->version/conversations/callbacks";
        $method = "POST";
        return $this->curlData($url, $method, $data);
    }

    public function postTransfer($conversationId, $participantId, $data){
        $url = "https://api.$this->env/api/$this->version/conversations/calls/$conversationId/participants/$participantId/replace";
        $method = "POST";
        return $this->curlData($url, $method, $data);
    }

    public function putRecordingState($conversationId, $data){
        $url = "https://api.$this->env/api/$this->version/conversations/calls/$conversationId/recordingstate";
        $method = "PUT";
        return $this->curlData($url, $method, $data);
    }

    public function postBatchRecording($data){
        $url = "https://api.$this->env/api/$this->version/recording/batchrequests";
        $method = "POST";
        return $this->curlData($url, $method, $data);
    }
    public function getBatchRecording($jobid){
        $url = "https://api.$this->env/api/$this->version/recording/batchrequests/$jobid";
        $method = "GET";
        return $this->curlData($url, $method);
    }
    
    public function getPaticipants($convsersationId){
		if(!$convsersationId) {return false;}
		$participants = $this->getConversationsCall($convsersationId);
		$participants = ($participants)?$participants->participants:false;
		$participants = array_filter(array_map(function($e) {
			$result = false;
			if(is_object($e)){
				if($e->purpose == "agent")
					$result = $e->id;
			} else {
				if($e['purpose'] == "agent")
					$result = $e['id'];
			}
			return $result;
		}, $participants));
        return $participants;
	}

    public function RecordingState($convsersationId, $state = 'ACTIVE'){
		if(!$convsersationId) {return false;}
        $data = (object) [
            "recordingState"=> $state,
        ];
		$return = $this->putRecordingState($convsersationId,$data);
        return $return;
	}

    public function patchUserQueue($userId, $queueId ,$data){
        $url = "https://api.$this->env/api/$this->version/users/$userId/queues/$queueId";
        $method = "PATCH";
        return $this->curlData($url, $method, $data);
    }

}

?>