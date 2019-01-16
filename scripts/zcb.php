<?php

//for loading
define('SYSPATH', 'fake');

include(__DIR__ . '/../application/classes/Zachestnyibiznes.php');

$config = include(__DIR__ . '/../application/config/config.php');

echo '<pre>';
print_r((new Zachestnyibiznes($config))->card($_REQUEST['inn']));