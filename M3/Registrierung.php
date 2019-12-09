<?php
namespace Emensa\Controller {
    require __DIR__ . '/vendor/autoload.php';
    require_once(__DIR__ . '/controllers/RegistrationController.php');

    $controller = new RegistrationController();
    $controller->invoke();


}
