<?php

$router->get('clear', 'OpcacheController@clear');
$router->get('config', 'OpcacheController@config');
$router->get('status', 'OpcacheController@status');
$router->get('optimize', 'OpcacheController@optimize');
