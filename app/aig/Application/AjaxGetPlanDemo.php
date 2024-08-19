<?php
error_reporting(0);
error_reporting(E_ERROR | E_PARSE);

include("../../function/StartConnect.inc");


if (isset($_POST['planDescription'])) {
    $planDescription = $_POST['planDescription'];
   
    // Fetch plan_poi based on planDescription
    $strSQL = "SELECT plan_poi FROM plans WHERE plan_description = ?";
    $stmt = $Conn->prepare($strSQL);
    $stmt->bind_param("s", $planDescription);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $planPoiData = [];
    while ($row = $result->fetch_assoc()) {
        $planPoiData[] = $row['plan_poi'];
    }
  
    // Fetch cover list based on plan_id
    $strSQL = "SELECT * FROM covers WHERE plan_id IN (SELECT plan_id FROM plans WHERE plan_description = ?)";
    $stmt = $Conn->prepare($strSQL);
    $stmt->bind_param("s", $planDescription);
    $stmt->execute();
    $result = $stmt->get_result();

    $coverList = [];
    while ($row = $result->fetch_assoc()) {
        $coverList[] = $row;
    }

    $response = [
        'planPoi' => $planPoiData,
        'coverList' => $coverList
    ];

    echo json_encode($response);
}
?>
