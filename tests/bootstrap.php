<?php

$loader = require __DIR__ . "/../vendor/autoload.php";
$loader->addPsr4('Opifer\\QueueIt\\', __DIR__);

date_default_timezone_set('UTC');
