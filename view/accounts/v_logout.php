<form class="logout-confirm-container" method="POST">
    <button name="answer"
           value= "Confirm"
           class="btn btn-outline-success"
           id="logoutConfirm">
        <?= \Bootstrap::__("Confirm") ?>
    </button>

    <button name="answer"
           value= "Cancel"
           class="btn btn-outline-danger"
           id="logoutCancel">
        <?= \Bootstrap::__("Cancel") ?>
    </button>
</form>