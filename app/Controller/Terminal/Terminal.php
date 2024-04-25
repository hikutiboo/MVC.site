<?php

namespace Controller\Terminal;

class Terminal extends \Controller\Controller
{
    static public function run() {
        $command = $_POST["command"];

        $exec = exec($command, $result);

        echo json_encode(["result" => mb_convert_encoding($result, 'UTF-8')]);
    }
}