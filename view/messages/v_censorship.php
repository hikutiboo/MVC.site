<?php
$alert = $viewData->getData('message');
if ($alert) {
    ?>
    <div class="alert alert-<?= $alert['type'] ?> border-<?= $alert['type'] ?>">
        <?= $alert['text'] ?>
    </div>
<?php } ?>
<div id="censorship_page">
    <div id="censorship_left_part" class="censorship-page-part">
        <form method="POST">
            <label class="h3" for="censorship_text">
                <?= \Bootstrap::__("Add new word to censorship") ?>
            </label>
            <br>
            <input name="new_word" id="censorship_text" type="text" placeholder="<?= \Bootstrap::__("Hello") ?>">
            <br><br>
            <button class="btn btn-outline-success" type="submit">
                <?= \Bootstrap::__("Add to censorship") ?>
            </button>
        </form>
        <hr>
        <div id="censored_messages_list">
            <h3><?= \Bootstrap::__("Censored Messages:") ?></h3>
            <?php foreach ($viewData->getData('censored') as $message): ?>
                <?php if (array_key_exists('type', $message) && $message['type'] === "system") { ?>
                    <strong><em><?= $message['message'] ?></em><br></strong>
                    <?php continue ?>
                <?php } ?>
                <?php
                $danger = $message['status'];
                $danger = $danger <= 3 ? "success" : ($danger <= 7 ? "warning" : 'danger');
                ?>
                <div class="border rounded border-<?= $danger ?> p-2 " id="message">
                    <label><strong><?= \Bootstrap::__('Message id') ?>
                            :&nbsp;</strong></label><em><?= $message['id'] ?></em><br>
                    <label><strong><?= \Bootstrap::__('User Name') ?>
                            :&nbsp;</strong></label><em><?= $message['name'] ?></em><br>
                    <label><strong><?= \Bootstrap::__('Title') ?>
                            :&nbsp;</strong></label><em><?= $message['title'] ?></em><br>
                    <label><strong><?= \Bootstrap::__('Message') ?>
                            :&nbsp;</strong></label><em><?= $message['message'] ?></em><br>
                    <label><strong><?= \Bootstrap::__('Created At') ?>
                            :&nbsp;</strong></label><em><?= $message['created_at'] ?></em><br>
                    <form method="POST">
                        <button class="btn btn-outline-danger"
                                type="submit"
                                name="delete"
                                value="<?= $message['id'] ?>">
                            <?= \Bootstrap::__("Delete") ?>
                        </button>
                        <button class="btn btn-outline-success"
                                type="submit"
                                name="allow"
                                value="<?= $message['id'] ?>">
                            <?= \Bootstrap::__("Allow") ?>
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div id="censorship_right_part" class="censorship-page-part">
        <h3><?= \Bootstrap::__("Censored Words:") ?></h3>
        <ul id="censored_words_list">
            <?php foreach ($viewData->getData('words') as $word): ?>
                <li class="censored-word">
                    <div class="censored-word-container">
                        <?= mb_strtolower($word['word']) ?>
                        <form method="POST">
                            <button class="btn btn-outline-danger"
                                    type="submit"
                                    name="delete_word"
                                    value="<?= $word['id'] ?>">
                                X
                            </button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>