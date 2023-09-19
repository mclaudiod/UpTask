<div class="container reset">
    <?php include_once __DIR__ . "/../templates/site-name.php"; ?>

    <div class="sm-container">
        <p class="page-description">Reset your Password</p>

        <?php include_once __DIR__ . "/../templates/alerts.php"; ?>

        <?php if($show) {?>
            <form class="form" method="POST">
                <div class="field">
                    <label for="password">New Password</label>
                    <input type="password" id="password" placeholder="Your new Password" name="password">
                </div>

                <div class="field">
                    <label for="rpassword">Repeat New Password</label>
                    <input type="password" id="rpassword" placeholder="Repeat your new Password" name="rpassword">
                </div>

                <input type="submit" class="button" value="Reset Password">
            </form>
        <?php } ?>

        <div class="actions">
            <a href="/">You already have an account? Log In</a>
            <a href="/forgot-password">Forgot your password?</a>
        </div>
    </div>
</div>