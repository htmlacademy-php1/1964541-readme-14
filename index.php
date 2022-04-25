<?php
require_once 'functions.php';
require_once 'helpers.php';
require_once 'data.php';

if (!isset($_SESSION['user'])) {
    print include_template('anon_layout.php');
}
