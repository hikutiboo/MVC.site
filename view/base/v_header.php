<?php
session_start();

$currentUser = $_SESSION['currentUser'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $viewData->getData('title') ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css">
</head>
<body>
<?php //if($_SESSION['role'] === 1) { ?>
    <script src="<?= BASE_URL ?>assets/js/adminConsole.js"></script>
<?php //} ?>
<header class="site-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">
            <div class="logo__title h3">Lesson site</div>
            <div class="logo__subtitle h6">About MVC</div>
        </div>
        <div class="account">
            <?php if (key_exists('username', $viewData->getData('currentUser') ?: [])) { ?>
                <div class="logo__title h3"><?= $viewData->getData('currentUser')['username'] ?? '' ?></div>
                <div class="logo__subtitle h6"><?= Bootstrap::__(${$viewData->getData('currentUser')['role'] ?? ''}) ?></div>
            <?php } else { ?>
                <div class="buttons">
                    <button type="button" class="btn btn-outline-light">
                        <a href="<?= BASE_URL ?>accounts/login"><?= Bootstrap::__('Log in') ?></a>
                    </button>
                    <button type="button" class="btn btn-danger">
                        <a href="<?= BASE_URL ?>accounts/register"><?= Bootstrap::__('Register') ?></a>
                    </button>
                </div>
            <?php } ?>
        </div>
    </div>
</header>