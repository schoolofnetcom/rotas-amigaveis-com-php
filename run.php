<?php

$path = $_SERVER['PATH_INFO'] ?? '/';

$result = explode('/', $path);

var_dump($result);
