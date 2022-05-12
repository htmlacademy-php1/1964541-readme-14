<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: index.php');
    exit;
} else {
    $user = $_SESSION;
}
