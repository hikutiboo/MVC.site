<?php

namespace Controller\Messages;

class Edit extends \Controller\Controller
{
    static public function run()
    {
        $data = $_POST;
        $title = \Bootstrap::__('Edit message');
        $connect = \DBAdapter::getConnection();
        $viewData = new \Model\ViewData();
        $neededFieldsArray = ['title', 'message'];
        $fields = \Arr::extractFields($data, $neededFieldsArray);
        $message_id = $_SESSION['edit_message'];
        $message = \Model\Messages::getMessage($connect, $message_id);
        $validateErrors = $_POST ? \Model\Messages::editingValidate($fields) : [];
        $testTitleOnCensorship = \Model\Messages::checkForCensorship($connect, $fields['title']);
        $testMessageOnCensorship = \Model\Messages::checkForCensorship($connect, $fields['message']);

        if ((!$testTitleOnCensorship['allow'] || !$testMessageOnCensorship['allow']) && count($_POST)) {
            $fields['title'] = $data['title'] ?: $fields['title'];
            $fields['message'] = $data['message'] ?: $fields['message'];
            $result = \Model\Messages::editMessage($connect, $message_id, $fields, 1);
            $_SESSION['is_message_censored'] = $testMessageOnCensorship['allow'] ? $testTitleOnCensorship : $testMessageOnCensorship;
            header('Location: ' . HOST . BASE_URL);
            var_dump($result);
            exit;
        }

        if (empty($validateErrors) && count($_POST)) {
            $fields['title'] = $data['title'] ?: $fields['title'];
            $fields['message'] = $data['message'] ?: $fields['message'];
            $result = \Model\Messages::editMessage($connect, $message_id, $fields);
            $_SESSION['successMessage'] = $result;
            header('Location: ' . HOST . BASE_URL);
            var_dump($result);
            exit;
        }

        $viewData->setData(['title' => $title, 'fields' => $fields, 'validateErrors' => $validateErrors, 'values' => $message]);
        \Model\RenderHTMLPage::renderHTML(['view/messages/v_edit.php'], $viewData);
    }
}