<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}
$user_name = $_SESSION['user'] ?? null;
