<?php

namespace Controller\Messages;

class Censorship extends \Controller\Controller
{
    static public function run()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 1) {
            echo "You are not welcome here!";
            header("Location: " . HOST . BASE_URL);
            exit();
        }
        $message = [];
        $data = $_POST;
        $viewData = new \Model\ViewData();
        $title = \Bootstrap::__('Censorship management');
        $connect = \DBAdapter::getConnection();

        if (array_key_exists("new_word", $data)) {
            $message = \Model\Messages::addCensoredWord($connect, $data['new_word']);
        }
        if (array_key_exists("delete", $data)) {
            $message = \Model\Messages::deleteMessage($connect, $data['delete']);
        }
        if (array_key_exists("allow", $data)) {
            $message = \Model\Messages::allowMessage($connect, $data['allow']);
        }
        if (array_key_exists("delete_word", $data)) {
            $message = \Model\Messages::deleteCensoredWord($connect, $data['delete_word']);
        }

        $extractedCensoredWords = \Model\Messages::getCensoredWords($connect);
        $extractedCensoredMessages = \Model\Messages::getCensoredMessages($connect);
        $censoredWords = empty($extractedCensoredWords) ?
            [['id' => 0, 'word' => \Bootstrap::__('There is no censored words yet!'), 'danger' => 0]] : $extractedCensoredWords;
        $censoredMessages = empty($extractedCensoredMessages) ?
            [['type' => "system", 'message' => \Bootstrap::__('There is no censored messages yet!')]] : $extractedCensoredMessages;

        $viewData->setData(['title' => $title, 'censored' => $censoredMessages, 'words' => $censoredWords, "message" => $message]);
        \Model\RenderHTMLPage::renderHTML(['view/messages/v_censorship.php'], $viewData);
    }
}