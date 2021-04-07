<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Spier\EnvReader\EnvReader;

(new EnvReader(__DIR__ . '/.env'))->load();

echo getenv('AUTHOR');