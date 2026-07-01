<?php

include '../../connection/connections.php';
session_start();

// clear session data
session_unset();
session_destroy();

// redirect always
header("Location: /lakan/index.php");
exit();