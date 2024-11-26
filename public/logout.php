<?php
session_start();
session_destroy(); // Encerra a sessão
header("Location: login.php");
exit();
?>
