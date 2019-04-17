<?php

define('ROOT', dirname(__FILE__, 2));
const CONFIG_DRIECTORY = ROOT . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;

require_once CONFIG_DRIECTORY . 'bootstrap.php';
require_once CONFIG_DRIECTORY . 'config.php';
require_once CONFIG_DRIECTORY . 'routes.php';

