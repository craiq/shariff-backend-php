<?php

require_once __DIR__.'/vendor/autoload.php';

use Heise\Shariff\Backend;
use Zend\Config\Reader\Json;

class Application
{
    public static function run()
    {

        if (!isset($_GET["url"])) {
            echo json_encode('no URL to check');
            return;
        }
        if(isset($_GET["callback"])) {
            header('Content-type: application/javascript');
        } else {
            header('Content-type: application/json');
        }

        $reader = new Json();

        $shariff = new Backend($reader->fromFile('shariff.json'));
        echo $_GET["callback"] ? $_GET["callback"].'(' . json_encode($shariff->get($_GET["url"])) . ');' : json_encode($shariff->get($_GET["url"]));
    }
}

Application::run();
