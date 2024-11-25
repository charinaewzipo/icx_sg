<?php
include "../../../dbconn.php";
include "../../../util.php";
include "../../../license.php";
include "../../../wlog.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
header('Content-Type: application/json; charset=UTF-8');

function logApiCall($endpoint, $requestPayload, $responsePayload, $statusCode, $errorMessage = null, $executionTime = null,$calllist_id=null,$agent_id=null,$import_id=null) {
  $dbconn = new dbconn();
  $res = $dbconn->createConn();

  if ($res == "404") {
      error_log("Failed to connect to database while logging API call");
      return false;
  }

  // Sanitize inputs
  $endpoint = mysqli_real_escape_string($dbconn->dbconn, $endpoint);
  $requestPayload = mysqli_real_escape_string($dbconn->dbconn, json_encode($requestPayload));
  $responsePayload = mysqli_real_escape_string($dbconn->dbconn, json_encode($responsePayload));
  $errorMessage = mysqli_real_escape_string($dbconn->dbconn, $errorMessage);

  // Build the SQL query
  $sql = "INSERT INTO t_aig_sg_api_call_logs (
              call_time, endpoint, request_payload, response_payload, status_code, error_message, execution_time,calllist_id,agent_id,import_id
          ) VALUES (
              NOW(), '$endpoint', '$requestPayload', '$responsePayload', $statusCode, 
              " . ($errorMessage ? "'$errorMessage'" : "NULL") . ", 
              " . ($executionTime ? $executionTime : "NULL") . ",$calllist_id,$agent_id,$import_id
          )";

  // Execute query
  $result = $dbconn->executeUpdate($sql);
  if (!$result) {
      error_log("Failed to log API call: " . mysqli_error($dbconn->dbconn));
      return false;
  }

  return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);

  if (json_last_error() !== JSON_ERROR_NONE) {
      echo json_encode(["result" => "error", "message" => "Invalid JSON"]);
      exit();
  }

  // ตรวจสอบ Action
  if (isset($data['action']) && $data['action'] === 'insertLogApiCall') {
      $endpoint = $data['endpoint'] ?? null;
      $requestPayload = $data['requestPayload'] ?? null;
      $responsePayload = $data['responsePayload'] ?? null;
      $statusCode = $data['statusCode'] ?? null;
      $errorMessage = $data['errorMessage'] ?? null;
      $executionTime = $data['executionTime'] ?? null;
      $calllist_id = $data['calllist_id'] ?? null;
      $agent_id = $data['agent_id'] ?? null;
      $import_id = $data['import_id'] ?? null;

      // บันทึก Log API
      $success = logApiCall($endpoint, $requestPayload, $responsePayload, $statusCode, $errorMessage, $executionTime,$calllist_id,$agent_id,$import_id);
      if ($success) {
          echo json_encode(["result" => "success"]);
      } else {
          echo json_encode(["result" => "error", "message" => "Failed to insert log"]);
      }
  } else {
      echo json_encode(["result" => "error", "message" => "Invalid action"]);
  }
  exit();
}


ob_end_flush();
exit();
