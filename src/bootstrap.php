<?php
require __DIR__ . '/../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

session_start();

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);

function view(string $template, array $data = []) {
    global $twig;
    echo $twig->render($template, $data);
    exit;
}

function redirect(string $path) {
    header("Location: $path");
    exit;
}
