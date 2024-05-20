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

        if (isset($_SESSION['is_message_added']) && $_SESSION['is_message_added']) {
            $successText = true;
            unset($_SESSION['is_message_added']);
        }
        if (isset($_POST['delete']) && gettype($_POST['delete']) === 'string') {
            var_dump($_POST['delete']);
            \Model\Messages::deleteMessage($connect, (int)$_POST['delete']);
            header("Location: " . HOST . BASE_URL);
        }

        $viewData->setData(['title'=>$title, 'messages'=>$messages, 'successText'=>$successText]);
        \Model\RenderHTMLPage::renderHTML(['view/messages/v_index.php'], $viewData);
    }
}