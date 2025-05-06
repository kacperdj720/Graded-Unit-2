<?php 
#logs out user and deletes current session
session_start() ;

$_SESSION = array() ;
session_destroy() ;
header('Location: home.php');

?>