<?php
$user = array_key_exists("user", $_SESSION) ? $_SESSION['user'] : [];
$role = setRole($user);

function setRole($user): string
{
    if (!array_key_exists("role", $user)) return '';

    return match ($_SESSION["user"]['role']) {
        1 => 'admin',
        2 => 'manager',
        3 => 'user',
        default => '',
    };
}
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
<?php if (key_exists('login', $user) && $_SESSION["user"]["role"] === 1) { ?>
    <script src="<?= BASE_URL ?>assets/js/adminConsole.js"></script>
<?php } ?>
<header class="site-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">
            <div class="logo__title h3">Lesson site</div>
            <div class="logo__subtitle h6"><?= \Bootstrap::__("About MVC") ?></div>
        </div>
        <div class="account">
            <?php if (key_exists('login', $user)) { ?>
                <div class="logo__title h3">
                    <?= $user["login"] ?? '' ?>
                    <a href="<?= BASE_URL ?>accounts/logout" class="btn btn-danger" id="logout">
                        <?= \Bootstrap::__("Log out") ?>
                    </a>
                </div>
                <div class="logo__subtitle h6">
                    <?= \Bootstrap::__("Role: ") .
                        \Bootstrap::__($role ?? '') ?>
                </div>
            <?php } else { ?>
                <div class="buttons">
                    <button type="button" class="btn btn-outline-light">
                        <a href="<?= BASE_URL ?>accounts/login"><?= \Bootstrap::__('Log in') ?></a>
                    </button>
                    <button type="button" class="btn btn-danger">
                        <a href="<?= BASE_URL ?>accounts/register"><?= \Bootstrap::__('Register') ?></a>
                    </button>
                </div>
            <?php } ?>
        </div>
    </div>
</header>