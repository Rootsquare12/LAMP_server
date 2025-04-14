<?php
    session_start();
    session_unset(); // 세션에 있는 정보 제거
    session_destroy(); // 세션 제거
    header("Location: login.php");
    die();
?>