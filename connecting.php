<?php

session_start();


require __DIR__ . '/vendor/autoload.php';

$mac = $_SESSION["id"]; // MAC ADREAS DO DEVICE
$ap = $_SESSION["ap"]; // MAC DA ANTENA


$duration = 43200; //Duration of authorization in minutes
$site_id = 'default'; //Site ID found in URL (https://1.1.1.1:8443/manage/site/<site_ID>/devices/1/50)

require_once '../config.php';

$unifi_connection = new UniFi_API\Client($controlleruser, $controllerpassword, $controllerurl, $site_id, $controllerversion);
$set_debug_mode = $unifi_connection->set_debug($debug);
$loginresults = $unifi_connection->login();

$auth_result = $unifi_connection->authorize_guest($mac, $duration, $up = null, $down = null, $MBytes = null, $ap);

//User will be authorized at this point; their name and email address can be saved to some database now

//Montamos o array com os dados
?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <title>WiFi Portal</title>
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="refresh" content="1;url=https://circulomilitar.org.br/" />
</head>

<body>
    <p>CONECTADO !</p>
</body>

</html>