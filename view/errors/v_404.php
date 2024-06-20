<main>
    <h1><?= $viewData->getData('$title') ?></h1>
    <div class="alert alert-warning">
        <p><?= \Bootstrap::__('Page not found.') ?></p>
        <p>
            <?= \Bootstrap::__('Start from') ?>
            <a href="<?= BASE_URL ?>">
                <?= \Bootstrap::__('main page') ?>
            </a>
        </p>
    </div>
</main>