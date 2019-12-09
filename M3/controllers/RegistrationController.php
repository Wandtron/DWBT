<?php

namespace Emensa\Controller {
    include_once(__DIR__ . '/../models/RegistrierungModel.php');

    Use eftec\bladeone\BladeOne;

// Use-Direktive
    $views = __DIR__ . '/../views';
    $cache = __DIR__ . '/../cache';
    $blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);

    class RegistrationController
    {
        private $blade;
        public $model;

        public function __construct()
        {
            $views = __DIR__ . '/../views';
            $cache = __DIR__ . '/../cache';
            $this->blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
            $this->model = RegistrierungModel::class ;
        }

        public function invoke()
        {
            $resultAccepted = (new \Emensa\Model\RegistrierungModel)->getRegistrierungSecondPage();
            if ($resultAccepted) {
                try {
                    echo '<meta http-equiv="refresh" content="0; URL=produkte.php?kat=0">';
                } catch (Exception $e) {
                }
            }
            $result = (new \Emensa\Model\RegistrierungModel)->getRegistrierungFirstPage();
            if (!($result))
                try {
                    echo $this->blade->run("pages.registration");
                } catch (Exception $e) {
                }
            if ($result) {
                try {
                    echo $this->blade->run("pages.registrationFinal");
                } catch (Exception $e) {
                }
            }
        }
    }
} ?>