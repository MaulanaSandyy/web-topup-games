<?php
// index.php

session_start();

require_once 'config/config.php';
require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/Model.php';
require_once 'core/Database.php';

$app = new App();
?>