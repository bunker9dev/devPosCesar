<?php

function avatar_url(?string $imagen, string $folder = 'users'): string
{
    $file = $imagen ?: 'default.png';

    $path = $_SERVER['DOCUMENT_ROOT'] . "/assets/img/{$folder}/" . $file;

    //  SI NO EXISTE, FORZAR DEFAULT
    if (!file_exists($path)) {
        $file = 'default.png';
        $path = $_SERVER['DOCUMENT_ROOT'] . "/assets/img/{$folder}/default.png";
    }

    $version = file_exists($path) ? filemtime($path) : time();

    return BASE_URL . "/assets/img/{$folder}/{$file}?v={$version}";
}