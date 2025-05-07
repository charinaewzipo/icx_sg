<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/dbconf.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/dbconn.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/util.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/class/ssp.class.php");


class DataTable
{

    private $dbsettings;
    private $campid;
    private $columns;
    private $uid;
    private $tabindex = 0;


    public function __construct()
    {
        global $db_server_ip;
        global $db_username;
        global $db_password;
        global $db_name;
        $this->dbsettings = array(
            'user' => $db_username,
            'pass' => $db_password,
            'db' => $db_name,
            'host' => $db_server_ip
        );
    }

    public function setcampid($campid)
    {
        $this->campid = $campid;
    }
    public function setuid($uid)
    {
        $this->uid = $uid;
    }
    public function settabindex($tabindex)
    {
        $this->tabindex = $tabindex;
    }

    public function getColumn()
    {
        if (!$this->campid)
            return false;
        $dbconn = new dbconn;
        $res = $dbconn->createConn();
        if ($res == 404) {
            $res = array("result" => "dberror", "message" => "Can't connect to database");
            echo json_encode($res);
            exit();
        }
        //campaign detail
        //init data ( show field in call work );

        $sql = " SELECT c.caption_name , c.field_name FROM t_campaign_field c WHERE c.campaign_id =  " . dbNumberFormat($this->campid) . " " .
            " AND c.show_on_callwork = 1 ";

        $tmp0 = array();

        if ($this->tabindex == 99) {
            $tmp0 = array_merge($tmp0, [
                [
                    "title" => "Tran_ID",
                    "dataC" => "call_id"
                ],
                [
                    "title" => "Call date/time",
                    "dataC" => "create_date"
                ]
            ]);
        } else {
            $tmp0 = array_merge($tmp0, [
                [
                    "title" => "ID",
                    "dataC" => "calllist_id"
                ],
                [
                    "title" => "List Name",
                    "dataC" => "list_name"
                ]
            ]);
        }
        $count = count($tmp0);
        $result = $dbconn->executeQuery($sql);
        while ($rs = mysqli_fetch_array($result)) {
            //get dynamic field for query data
            $tmp0[$count] = array(
                "title" => nullToEmpty($rs['caption_name']),
                "dataC" => nullToEmpty($rs['field_name']),
            );
            $count++;
        }
        if ($this->tabindex > 0 && $this->tabindex < 99) {
            $tmp0 = array_merge($tmp0, [
                [
                    "title" => "Last wrapup",
                    "dataC" => "last_wrapup_id"
                ],
                [
                    "title" => "Detail",
                    "dataC" => "last_wrapup_detail"
                ],
                [
                    "title" => "Number of call",
                    "dataC" => "number_of_call"
                ],
                [
                    "title" => "Call date/time",
                    "dataC" => "last_wrapup_dt"
                ]
            ]);
        } else if ($this->tabindex == 99) {
            $tmp0 = array_merge($tmp0, [
                [
                    "title" => "Last wrapup",
                    "dataC" => "wrapup_id"
                ],
                [
                    "title" => "Detail",
                    "dataC" => "wrapup_note"
                ],
                [
                    "title" => "Voice",
                    "dataC" => "voice_id"
                ]
            ]);
        }
        $dbconn->dbClose();
        $this->columns = $tmp0;
        return $tmp0;
    }

    public function getDetail($get = null)
    {
        if (!$this->campid || !$this->uid)
            return false;
        if (!$this->columns)
            $this->getColumn();

        $primaryKey = 'calllist_id';
        $columns = array();
        $count = 0;
        foreach ($this->columns as $colmun) {
            $datac = $colmun["dataC"];
            $column_tmp = array();
            $column_tmp = array('db' => '`c`.`' . $datac . '`', 'dt' => $count, 'field' => $datac);
            if (in_array($datac, array("calllist_id", "last_wrapup_id", "last_wrapup_detail", "number_of_call", "last_wrapup_dt"))) {
                $column_tmp['db'] = '`a`.`' . $datac . '`';
            } else if (in_array($datac, array("call_id", "wrapup_id", "wrapup_note", "voice_id", "create_date"))) {
                $column_tmp['db'] = 't.' . $datac . '';
            } else if (in_array($datac, array("list_name"))) {
                $column_tmp['db'] = '`l`.`' . $datac . '`';
            }
            array_push($columns, $column_tmp);
            $count++;
        }

        if ($this->tabindex == 99) {
            $table = "t_call_trans";
            $joinQuery = "FROM `t_call_trans` AS `t`
        LEFT OUTER JOIN `t_calllist` AS `c` ON `t`.calllist_id = `c`.`calllist_id`";
            $extraWhere = "`t`.`agent_id` = " . dbNumberFormat($this->uid) . " AND `t`.`campaign_id` = " . dbNumberFormat($this->campid);
        } else {
            $table = "t_calllist_agent";
            $joinQuery = "FROM `t_calllist_agent` AS `a`
        LEFT OUTER JOIN `t_calllist` AS `c` ON `a`.calllist_id = `c`.`calllist_id`
        LEFT OUTER JOIN `t_import_list` AS `l` ON `a`.`import_id` = `l`.`import_id`";
            $extraWhere = "`a`.`agent_id` = " . dbNumberFormat($this->uid) . " AND `a`.`status` = 1 AND `a`.`campaign_id` = " . dbNumberFormat($this->campid);
            if ($this->tabindex) {
                $extraWhere .= " AND `a`.`last_wrapup_option_id` IN ( SELECT `option_id` FROM `ts_call_tab_wrapup` WHERE `tab_id` = " . dbNumberFormat($this->tabindex) . " )";
            } else {
                $extraWhere .= " AND `a`.`last_wrapup_option_id` IS NULL";
            }
        }
        ob_end_clean();
        echo json_encode(
            SSP::simple($get, $this->dbsettings, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
        );
    }

}

?>