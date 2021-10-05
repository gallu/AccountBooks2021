<?php   // twig_test.php

require_once(__DIR__ . '/vendor/autoload.php');

// Twigインスタンスを生成
$path = __DIR__ . '/templates';
$twig = new \Twig\Environment( new \Twig\Loader\FilesystemLoader($path) );

//
echo $twig->render('twig_test.twig', ['name' => 'おい<ち>ゃん']);
