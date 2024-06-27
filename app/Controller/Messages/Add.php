<?php

namespace Controller\Messages;

class Add extends \Controller\Controller
{
    static public function run()
    {
        $data = $_POST;
        $title = \Bootstrap::__('Add message');
        $data['name'] = $_SESSION['user']['login'] ?? null;
        $data['email'] = $_SESSION['user']['email'] ?? null;
        $connect = \DBAdapter::getConnection();
        $viewData = new \Model\ViewData();
        $neededFieldsArray = ['name', 'title', 'message', 'email'];
        $fields = \Arr::extractFields($data, $neededFieldsArray);
        $validateErrors = $_POST ? \Model\Messages::messagesValidate($fields, $_SESSION['user']['role'] ?? 0) : [];
        $testMessageOnCensorship = \Model\Messages::checkForCensorship($connect, $fields['message']);
        $testTitleOnCensorship = \Model\Messages::checkForCensorship($connect, $fields['title']);

        if ((!$testMessageOnCensorship['allow'] || !$testTitleOnCensorship['allow']) && count($_POST)) {
            \Model\Messages::setMessage($connect, $fields, 1);
            $_SESSION['is_message_censored'] = $testMessageOnCensorship['allow'] ? $testTitleOnCensorship : $testMessageOnCensorship;
            header('Location: ' . HOST . BASE_URL);
            exit;
        }

        if (empty($validateErrors) && count($_POST)) {
            $result = \Model\Messages::setMessage($connect, $fields);
            $_SESSION['is_message_added'] = $result;
            header('Location: ' . HOST . BASE_URL);
            exit;
        }

        $viewData->setData(['title' => $title, 'fields' => $fields, 'validateErrors' => $validateErrors]);
        \Model\RenderHTMLPage::renderHTML(['view/messages/v_add.php'], $viewData);
    }
}