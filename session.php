<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: index.php');
    exit;
} else {
    foreach ($_SESSION as $key => $value) {
        $user[$key] = $value;
    }
}

