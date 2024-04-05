<?php

    session_start();
    session_unset();
    session_destroy();
    header("location: http://localhost:31337/project/admin-panel/admins/login-admins.php")

?>