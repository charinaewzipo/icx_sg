<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$apiClient = new ApiClient('https://qa.apacnprd.api.aig.com/sg-gateway/eway-rest/premium-calculation');

try {
    $body = [
        "propDate" => "2024-07-26T18:25:43.511Z",
        "productId" => "600000060",
        "distributionChannel" => "10",
        "producerCode" => "0000064000",
        "applicationReceivedDate" => "",
        "policyEffDate" => "",
        "policyExpDate" => "",
        "insuredList" => [[
            "addressInfo" => [
                "ownerOccupiedType" => "62"
            ]
        ]]
    ];

    // Ensure getPremiumHome is correctly defined
    $data = $apiClient->getPremiumHome($body);
    print_r($data);
    // Check if 'Policy' key exists in response
    if (isset($data['Policy']['insuredList'][0])) {
        $premiumData = $data['Policy']['insuredList'][0];
        echo json_encode($premiumData);
    } else {
        echo json_encode(['error' => 'Invalid API response.']);
    }

} catch (Exception $e) {
    error_log('Error: ' . $e->getMessage());
    echo json_encode(['error' => 'An error occurred.']);
}
?>
