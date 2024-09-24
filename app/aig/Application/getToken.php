<?php
include_once '../../../app/function/settings.php';

$token_url = $GLOBALS['token_url'];
$client_id = $GLOBALS['client_id'];
$client_secret = $GLOBALS['client_secret'];
$scope = $GLOBALS['scope'];

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
                var token = '$access_token';
                localStorage.setItem('accessToken', token);
            </script>";
    }
}

?>