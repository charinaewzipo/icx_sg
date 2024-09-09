<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$token_url = 'https://devauth1.customerpltfm.aig.com/oauth2/ausmgmbyeSo2EHuJs1d6/v1/token';
$client_id = '0oaftcvxzeeCm0rk11d7';
$client_secret = '-qe3hBBkSRPNTCmhkGoXVfdD3UH48g2UFH9O9HzdfSDFnL_AVQgWZ1SQu3UkU1K-';
$scope = 'SGEwayPartners_IR';


$data = [
    'grant_type' => 'client_credentials',
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'scope' => $scope
];

$ch = curl_init($token_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
$err = curl_error($ch);

curl_close($ch);

if ($err) {

} else {
    $token_data = json_decode($response, true);
    $access_token = $token_data['access_token'] ?? null;
    
    if ($access_token) {
        echo "<script>
                var tokenAccess = '$access_token';
                localStorage.setItem('accessToken', tokenAccess);
            </script>";
    }
}

?>