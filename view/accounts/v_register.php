<?php if ($viewData->getData('error')) { ?>
    <div class="alert alert-danger border-danger">
        <?= $viewData->getData('error') ?>
    </div>
<?php } ?>
<form id="register_form" method="POST">
    <label for="username">Username: </label>
    <input name="login" id="username" type="text" placeholder="Username">

    <br><br>

    <label for="password">Password: </label>
    <input name="password" id="password" type="password" placeholder="Password">

    <br><br>

    <label for="email">Email: </label>
    <input name="email" id="email" type="text" placeholder="Email">

    <br><br>

    <label for="role">Role: </label>
    <select name="role" id="role">
        <option value="3" class="role-option" selected>User</option>
        <option value="2" class="role-option">Manager</option>
        <option value="1" class="role-option">Admin</option>
    </select>

    <p><b>Rules:</b></p>
    <ul>
        <li>Fields should not be empty</li>
        <li>Minimal length for every field is 3 symbols</li>
        <li>Maximal length for every field is 24 symbols (excepting email field)</li>
        <li>Username should not contain spaces</li>
        <li>Minimal length for password is 8 symbols</li>
    </ul>

    <button type="submit">Register</button>

    <p id="result"></p>
</form>