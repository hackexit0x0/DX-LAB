<?php

// your logout code here
session_start();
session_destroy();
header("Location: ../user/login.php");

?>