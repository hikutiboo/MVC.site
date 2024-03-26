<?php

namespace Controller\Messages;

class Add extends \Controller\Controller
{
    static public function run()
    {

        $viewData = new \Model\ViewData();
        $title = \Bootstrap::__('Add message');
        $fieldsNotCleaned = $_POST;
        $neededFieldsArray = ['name', 'title', 'message'];

        $fields = \Arr::extractFields($_POST, $neededFieldsArray);

        $validateErrors = $_POST ? \Model\Messages::messagesValidate($fields) : [];

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