<?php if ($viewData->getData('successText')): ?>
    <div class="alert alert-success" role="alert">
        <?= $viewData->getData('successText') ?>
    </div>
<?php endif; ?>
<?php if ($viewData->getData('censorshipText')): ?>
    <div class="alert alert-danger" role="alert">
        <?= $viewData->getData('censorshipText') ?>
    </div>
<?php endif; ?>
<ul>
    <?php foreach ($viewData->getData('messages') as $message): ?>
        <li>
            <label><strong><?= \Bootstrap::__('Message id') ?>:&nbsp;</strong></label><em><?= $message['id'] ?></em><br>
            <label><strong><?= \Bootstrap::__('User Name') ?>
                    :&nbsp;</strong></label><em><?= $message['name'] ?></em><br>
            <label><strong><?= \Bootstrap::__('Title') ?>:&nbsp;</strong></label><em><?= $message['title'] ?></em><br>
            <label><strong><?= \Bootstrap::__('Message') ?>
                    :&nbsp;</strong></label><em><?= $message['message'] ?></em><br>
            <label><strong><?= \Bootstrap::__('Created At') ?>
                    :&nbsp;</strong></label><em><?= $message['created_at'] ?></em><br>
            <div class="message-buttons">
                <?php if (
                    ($_SESSION['user']['role'] ?? 3) < 3 ||
                    ($_SESSION['user']['email'] ?? null) === $message['author_email']
                ) { ?>
                    <form method="post">
                        <button class="btn btn-outline-danger"
                                type="submit"
                                name="delete<?= ($_SESSION['user']['email'] ?? null) === $message['author_email'] ? "d_by_yourself" : '' ?>"
                                value="<?= $message['id'] ?>">
                            <?= \Bootstrap::__('Delete') ?>
                        </button>
                    </form>
                <?php } ?>
                <?php if (($_SESSION['user']['email'] ?? null) === $message['author_email']) { ?>
                    <form method="post">
                        <button class="btn btn-outline-warning"
                                type="submit"
                                name="edit"
                                value="<?= $message['id'] ?>">
                            <?= \Bootstrap::__('Edit') ?>
                        </button>
                    </form>
                <?php } ?>
            </div>
            <hr>
        </li>
    <?php endforeach; ?>
</ul>
