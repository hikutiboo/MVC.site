<?php

namespace Controller\Messages;

class Index extends \Controller\Controller
{
    static public function run()
    {
        $viewData = new \Model\ViewData();
        $title = \Bootstrap::__('Chat List');
        $messages = \Model\Messages::getMessages(\DBAdapter::getConnection());
        $successText = false;

        if (isset($_SESSION['is_message_added']) && $_SESSION['is_message_added']) {
            $successText = true;
            unset($_SESSION['is_message_added']);
        }

        $viewData->setData(['title'=>$title, 'messages'=>$messages, 'successText'=>$successText]);
        \Model\RenderHTMLPage::renderHTML(['view/messages/v_index.php'], $viewData);
    }
}