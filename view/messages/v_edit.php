<?php
$titleText = $viewData->getData('fields')['title'] ?: ($viewData->getData('values')['title'] ?? '');
$messageText = $viewData->getData('fields')['message'] ?: ($viewData->getData('values')['message'] ?? '');
?>
<form method="post">
    <div>
        <label for="messageName"><?= \Bootstrap::__('Title') ?></label>
        <input id="messageName" name="title" value="<?= $titleText ?>">
    </div>
    <div>
        <label for="messageId"><?= \Bootstrap::__('Message') ?></label>
        <textarea type="text" name="message"
                  id="messageId"><?= $messageText ?></textarea>
    </div>

    <input name="submit" value="<?= \Bootstrap::__('Save') ?>" type="submit">
</form>
<div>
    <?php foreach ($viewData->getData('validateErrors') ?: [] as $error): ?>
        <p><?= $error ?></p>
    <?php endforeach; ?>
</div>