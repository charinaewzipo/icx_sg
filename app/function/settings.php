<?php

//Database 
$GLOBALS["db_server"] = "195.179.239.102";
$GLOBALS["db_database"] = "u297918512_icx_sg";
$GLOBALS["db_user"] = "u297918512_root";
$GLOBALS["db_password"] = '3Y:zMKKe>8';
// $GLOBALS["db_server"] = "icxpoc-db2.clce66q2ulno.ap-southeast-1.rds.amazonaws.com";
// $GLOBALS["db_database"] = "tubtim20240906";
// $GLOBALS["db_user"] = "arkuser";
// $GLOBALS["db_password"] = '$ep2@24ICX';

$GLOBALS["app_db_server"] = "icxpoc-db2.clce66q2ulno.ap-southeast-1.rds.amazonaws.com";
$GLOBALS["app_db_database"] = "tubtim20240906";
$GLOBALS["app_db_user"] = "arkuser";
$GLOBALS["app_db_password"] = '$ep2@24ICX';

//Mail
$GLOBALS["m_smtp_host"] = "smtp.hostinger.com";
$GLOBALS["m_smtp_port"] = "465";
$GLOBALS["m_smtp_authen"] = true;
$GLOBALS["m_charset"] = "utf-8";
$GLOBALS["m_user"] = "admin@arkinsightsbpo.com";
$GLOBALS["m_password"] = "P@ssw0rd";
$GLOBALS["m_from_name"] = "ARK-SYSTEM";

//AIG_API
$GLOBALS["aig_api_premium_url"] = "https://qa.apacnprd.api.aig.com/sg-gateway/eway-rest/premium-calculation";
$GLOBALS["aig_api_create_quote_url"] = "https://uat.apacnprd.api.aig.com/sg-gateway/eway-rest/v3/confirm-quotation";
$GLOBALS["aig_api_create_policy_url"] = "https://uat.apacnprd.api.aig.com/sg-gateway/eway-rest/issue-policy";
$GLOBALS["aig_api_retrieve_quote_url"] = "https://uat.apacnprd.api.aig.com/sg-gateway/eway-rest/v3/retrieve-quote";
$GLOBALS["aig_api_recalculate_quote_url"] = "https://uat.apacnprd.api.aig.com/sg-gateway/eway-rest/reCalculate-Quotation";


// $GLOBALS["aig_api_premium_url"] = "https://qa.apacnprd.api.aig.com/sg-gateway/eway-rest/premium-calculation";
// $GLOBALS["aig_api_create_quote_url"] = "https://qa.apacnprd.api.aig.com/sg-gateway/eway-rest/v3/confirm-quotation";
// $GLOBALS["aig_api_create_policy_url"] = "https://qa.apacnprd.api.aig.com/sg-gateway/eway-rest/issue-policy";
// $GLOBALS["aig_api_retrieve_quote_url"] = "https://qa.apacnprd.api.aig.com/sg-gateway/eway-rest/v3/retrieve-quote";
// $GLOBALS["aig_api_recalculate_quote_url"] = "https://uat.apacnprd.api.aig.com/sg-gateway/eway-rest/reCalculate-Quotation";

//token
$GLOBALS['token_url'] = 'https://uatauth1.customerpltfm.aig.com/oauth2/ausuekxpsCZZKg0Cw1d6/v1/token';
$GLOBALS['client_id'] = '0oah441lav0OCFPY11d7';
$GLOBALS['client_secret'] = 'yzE2jf3gECLTElZxs2pSNWdTklUzYtdjg2sfzuf9_O2VFgaAN3Ya669A2tsbhRQG';
$GLOBALS['scope'] = 'SGEwayPartners_IR';
// $GLOBALS['token_url'] = 'https://devauth1.customerpltfm.aig.com/oauth2/ausmgmbyeSo2EHuJs1d6/v1/token';
// $GLOBALS['client_id'] = '0oaftcvxzeeCm0rk11d7';
// $GLOBALS['client_secret'] = '-qe3hBBkSRPNTCmhkGoXVfdD3UH48g2UFH9O9HzdfSDFnL_AVQgWZ1SQu3UkU1K-';
// $GLOBALS['scope'] = 'SGEwayPartners_IR';

//payment
$GLOBALS['merchant'] = 'TEST97498471';
$GLOBALS['username'] = "merchant." . $GLOBALS['merchant'];
$GLOBALS['password'] = '8fb334a463b16d4e4d19e3f7639edfd4';
$GLOBALS['url_create_session'] = "https://ap-gateway.mastercard.com/api/rest/version/llaatteesstt/merchant/" . $GLOBALS['merchant'] . "/session";
$GLOBALS['url_get_payment_detail'] = "https://ap-gateway.mastercard.com/api/rest/version/llaatteesstt/merchant/" . $GLOBALS['merchant'];
$GLOBALS['url_create_token'] = "https://ap-gateway.mastercard.com/api/rest/version/llaatteesstt/merchant/" . $GLOBALS['merchant'];

?>
