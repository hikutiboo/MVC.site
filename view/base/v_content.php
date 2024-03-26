<nav class="site-nav">
    <div class="container">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="<?=BASE_URL?>"><?= Bootstrap::__('Home')?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=BASE_URL?>messages/add"><?= Bootstrap::__('Add')?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=BASE_URL?>contacts"><?= Bootstrap::__('Contacts')?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=BASE_URL?>contacts"><?= Bootstrap::__('Not Exists')?></a>
            </li>
        </ul>
    </div>
</nav>
<div class="site-content">
    <div class="container">
        <main>
            <h1><?=$viewData->getData('title')?></h1>
            <hr>
