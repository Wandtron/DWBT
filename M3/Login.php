<?php
namespace Emensa\Controller {
    session_start();
    require __DIR__ . '/vendor/autoload.php';

// Blade
    Use eftec\bladeone\BladeOne;

    $views = __DIR__ . '/views';
    $cache = __DIR__ . '/cache';
    $blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);

    try {
        echo $blade->run("pages.login");
    } catch (Exception $e) {
    }
}
