<?php
session_start();
if ($_SESSION['user']) {
    header('Location: feed.php');
}
