<?php

namespace Controller\Messages;

class Add extends \Controller\Controller
{
    static public function run()
    {
        $data = $_POST;
        $data['name'] = $_SESSION['user']['login'] ?? null;
        $viewData = new \Model\ViewData();
        $title = \Bootstrap::__('Add message');
        $neededFieldsArray = ['name', 'title', 'message'];
        $fields = \Arr::extractFields($data, $neededFieldsArray);
        $validateErrors = $_POST ? \Model\Messages::messagesValidate($fields, $_SESSION['user']['role'] ?? 0) : [];

        if (empty($validateErrors) and count($_POST)) {
            $result = \Model\Messages::setMessage(\DBAdapter::getConnection(), $fields);
            $_SESSION['is_message_added'] = $result;
            header('Location: ' . HOST . BASE_URL);
            exit;
        }

        $viewData->setData(['title' => $title, 'fields' => $fields, 'validateErrors' => $validateErrors]);
        \Model\RenderHTMLPage::renderHTML(['view/messages/v_add.php'], $viewData);
    }
}