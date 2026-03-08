<?php
 include __DIR__ . '/../configs/constants.php';
    session_unset();
    session_destroy();
    header('Location: ' . SITEURL . 'index.php');
?>
