<?php

namespace Model;

class Terminal
{
    static public function searchForPresetCommand(\mysqli $connect, string $command): mixed
    {
        $response = '';
        $presets = self::presets();

        foreach ($presets as $preset) {
            if (preg_match($preset['regex'], $command)) {
                $functionName = $preset['function'];
                $response = self::$functionName($connect);
            }
        }
        return $response;
    }

    static public function presets(): array
    {
        return [
            [
                'regex' => '/mvc moderate/',
                'function' => 'moderateMessages'
            ],
            [
                'regex' => '/mvc helloworld/',
                'function' => 'helloWorld'
            ]
        ];
    }

    static public function helloWorld(): array
    {
        return ['Hello you too!'];
    }

    static public function moderateMessages(\mysqli $connect): array
    {
        $result = ["Messages successfully moderated"];
        $messages = \Model\Messages::getMessages($connect);

        foreach ($messages as $message) {
            $allowedMessage = \Model\Messages::checkForCensorship($connect, $message['message'])['allow'];
            $allowedTitle = \Model\Messages::checkForCensorship($connect, $message['title'])['allow'];

            if (!$allowedMessage || !$allowedTitle) {
                \Model\Messages::moderateMessage($connect, $message['id']);
            }

            if (mysqli_error($connect)) {
                $result = ["Something went wrong, some messages may not have been moderated!"];
            }
        }
        return $result;
    }
}