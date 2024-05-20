<form method="post">
    <div>
        <label for="messageName"><?= \Bootstrap::__('Title') ?></label>
        <input id="messageName" name="title" value="<?= $viewData->getData('fields')['title']??'' ?>">
    </div>
    <div>
        <label for="messageId"><?= \Bootstrap::__('Message') ?></label>
        <textarea type="text" name="message" id="messageId"><?= $viewData->getData('fields')['message']??'' ?></textarea>
    </div>

    <input name="submit" value="<?= \Bootstrap::__('Save') ?>" type="submit">
</form>
<div>
    <?php foreach($viewData->getData('validateErrors') as $error): ?>
        <p><?=$error?></p>
    <?php endforeach; ?>
</div>