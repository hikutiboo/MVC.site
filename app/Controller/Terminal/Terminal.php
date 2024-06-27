<?php

namespace Controller\Terminal;

class Terminal extends \Controller\Controller
{
    static public function run() {
//        $command = $_POST["command"];
//
//        $exec = exec($command, $result);
//
//        echo json_encode(["result" => mb_convert_encoding($result, 'UTF-8')]);
        $command = $_POST["command"];
        $connect = \DBAdapter::getConnection();
        $result = \Model\Terminal::searchForPresetCommand($connect, $command);

        if ($result) {
            echo json_encode(["result" => $result]);
            exit;
        }

        exec($command, $result);
        echo json_encode(["result" => mb_convert_encoding($result, 'UTF-8')]);
    }
}
//        $command = $_POST["command"];
//        $connect = \DBAdapter::getConnection();
//        $result = \Model\Terminal::searchForPresetCommand($connect, $command);
//
//        if ($result) {
//            echo json_encode(["result" => $result]);
//            exit;
//        }
//        exec($command, $result);
//        var_dump(mb_convert_encoding($result, 'UTF-8'));
//        echo json_encode(["result" => mb_convert_encoding($result, 'UTF-8')]);