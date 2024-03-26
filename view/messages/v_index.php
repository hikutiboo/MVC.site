<?php if ($viewData->getData('successText')): ?>
    <div class="alert alert-success" role="alert">
        <?= Bootstrap::__('The message has been successfully added!') ?>
    </div>
<?php endif; ?>
<ul>
    <?php foreach ($viewData->getData('messages') as $message): ?>
    <li>
        <label><strong><?= Bootstrap::__('Message id') ?>:</strong></label><em><?= $message['id'] ?></em><br>
        <label><strong><?= Bootstrap::__('User Name') ?>:</strong></label><em><?= $message['name'] ?></em><br>
        <label><strong><?= Bootstrap::__('Title') ?>:</strong></label><em><?= $message['title'] ?></em><br>
        <label><strong><?= Bootstrap::__('Message') ?>:</strong></label><em><?= $message['message'] ?></em><br>
        <label><strong><?= Bootstrap::__('Created At') ?>:</strong></label><em><?= $message['created_at'] ?></em><br>
        <hr>
    </li>
    <?php endforeach; ?>
</ul>
