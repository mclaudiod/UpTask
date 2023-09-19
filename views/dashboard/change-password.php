<?php include_once __DIR__ . "/header.php"; ?>

<div class="sm-container">
    <?php include_once __DIR__ . "/../templates/alerts.php"; ?>

    <a href="/profile" class="link">Return to Profile</a>

    <form class="form" action="/change-password" method="POST">
            <div class="field">
                <label for="cpassword">Current Password</label>
                <input type="password" id="cpassword" placeholder="Your Current Password" name="cpassword">
            </div>

            <div class="field">
                    <label for="npassword">New Password</label>
                    <input type="password" id="npassword" placeholder="Your new Password" name="npassword">
                </div>

                <div class="field">
                    <label for="rpassword">Repeat New Password</label>
                    <input type="password" id="rpassword" placeholder="Repeat your new Password" name="rpassword">
                </div>

                <input type="submit" class="button" value="Change Password">
    </form>
</div>

<?php include_once __DIR__ . "/footer.php"; ?>