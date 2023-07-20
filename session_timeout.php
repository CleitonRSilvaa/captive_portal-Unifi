<?php
$inactivityTimeout = 20 * 60;

ini_set('session.gc_maxlifetime', $inactivityTimeout);

session_start();

if (isset($_SESSION['lastActivity']) && time() - $_SESSION['lastActivity'] > $inactivityTimeout) {
  session_unset();
  session_destroy();
  header("Location: ../admin/index.php");
  exit;
}

$_SESSION['lastActivity'] = time();
