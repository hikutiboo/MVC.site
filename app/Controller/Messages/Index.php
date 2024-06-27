<?php

namespace Controller\Messages;

class Index extends \Controller\Controller
{
    static public function run()
    {
        $viewData = new \Model\ViewData();
        $title = \Bootstrap::__('Chat List');
        $messages = \Model\Messages::getMessages(\DBAdapter::getConnection());
        $connect = \DBAdapter::getConnection();
        $successText = false;
        $censorshipText = '';

        if (isset($_SESSION['is_message_censored']) && !$_SESSION['is_message_censored']['allow']) {
            $censorshipText = $_SESSION['is_message_censored']['message'];
            unset($_SESSION['is_message_censored']);
        }

        if (isset($_SESSION['is_message_added']) && $_SESSION['is_message_added']) {
            $successText = \Bootstrap::__('The message has been successfully added!');
            unset($_SESSION['is_message_added']);
        }

        if (isset($_SESSION['successMessage']) && $_SESSION['successMessage']['success']) {
            $successText = $_SESSION['successMessage']['message'];
            unset($_SESSION['successMessage']);
        }

        if (isset($_POST['delete']) && gettype($_POST['delete']) === 'string') {
            \Model\Messages::moderateMessage($connect, (int)$_POST['delete']);
            header("Location: " . HOST . BASE_URL);
        }

        if (isset($_POST['deleted_by_yourself']) && gettype($_POST['deleted_by_yourself']) === 'string') {
            \Model\Messages::moderateMessage($connect, (int)$_POST['deleted_by_yourself'], 2);
            header("Location: " . HOST . BASE_URL);
        }

        if (isset($_POST['edit']) && gettype($_POST['edit']) === 'string') {
            $_SESSION['edit_message'] = $_POST['edit'];
            header("Location: " . HOST . BASE_URL . "messages/edit");
        }

        $viewData->setData(['title' => $title, 'messages' => $messages, 'successText' => $successText, 'censorshipText' => $censorshipText]);
        \Model\RenderHTMLPage::renderHTML(['view/messages/v_index.php'], $viewData);
    }
}