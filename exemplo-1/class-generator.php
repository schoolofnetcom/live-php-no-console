<?php

if (empty($argv[1])) {
    die('Informe o vendor name da class');
}

if (empty($argv[2])) {
    die('Informe o diretório ao qual o vendor name se refere');
}

if (empty($argv[3])) {
    die('Informe o nome da classe com namespace');
}

$folders = str_replace($argv[1], $argv[2], $argv[3]);
$folders = explode('\\', $folders);
$file = array_pop($folders);

$directory = __DIR__ . '/';

foreach ($folders as $folder) {
    $directory .= $folder . '/';
    if (!is_dir($directory)) {
        mkdir($directory);
    }
}

$namespace = explode('\\', $argv[3]);
$file = array_pop($namespace);
$namespace = implode('\\', $namespace);

$template = file_get_contents(__DIR__ . '/template');

$template = str_replace('{{ namespace }}', $namespace, $template);
$template = str_replace('{{ class }}', $file, $template);

file_put_contents($directory . $file . '.php', $template);
