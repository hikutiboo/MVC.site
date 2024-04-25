<?php if ($viewData->getData('error')) { ?>
    <div class="alert alert-danger border-danger">
        <?= $viewData->getData('error') ?>
    </div>
<?php } ?>
<form id="login_form" method="POST">
    <label for="email">Email: </label>
    <input name="email" id="email" type="text" placeholder="youremail@email.com">
    <br>
    <label for="password">Password: </label>
    <input name="password" id="password" type="password" placeholder="Password">

    <br><br>

    <button type="submit">Log in</button>

    <br><br>

    <p class="forgetPasswordRow">
        Forgot your password? Click <a href="forgetPassword.html" id="forget_password">here</a> to recover it!
    </p>

    <p id="result"></p>
</form>