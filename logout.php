<?php
session_start();
session_destroy();
header("Location: principal/index.php");
exit;
?>