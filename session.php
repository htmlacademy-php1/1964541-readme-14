<?php
session_start();
if (empty($_SESSION['user']) && $_SERVER['PHP_SELF'] !== '/index.php' && $_SERVER['PHP_SELF'] !== '/registration.php') {
    header('Location: index.php');
}

$user_name = $_SESSION['user'] ?? null;
