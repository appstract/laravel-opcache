<?php

Route::get('clear', 'OpcacheController@clear');
Route::get('config', 'OpcacheController@config');
Route::get('status', 'OpcacheController@status');
Route::get('optimize', 'OpcacheController@optimize');