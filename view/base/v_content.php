<?php $ln = $_SESSION["ln"] ?? "en"; ?>
<nav class="site-nav">
    <div class="container">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>"><?= \Bootstrap::__('Home') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>messages/add"><?= \Bootstrap::__('Add') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>contacts"><?= \Bootstrap::__('Contacts') ?></a>
            </li>
            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 1): ?>
                <li class="nav-item">
                    <a class="nav-link"
                       href="<?= BASE_URL ?>messages/censorship"><?= \Bootstrap::__('Censorship') ?></a>
                </li>
            <?php endif; ?>
        </ul>
        <form method="get">
            <select name="ln" onchange="this.form.submit()">
                <option value="en" <?= $ln == "en" ? "selected" : '' ?>>English</option>
                <option value="ua" <?= $ln == "ua" ? "selected" : '' ?>>Ukrainian</option>
                <option value="pl" <?= $ln == "pl" ? "selected" : '' ?>>Polish</option>
            </select>
        </form>
    </div>
</nav>
<div class="site-content">
    <div class="container page-container">
        <main>
            <h1><?= $viewData->getData('title') ?></h1>
            <hr>
