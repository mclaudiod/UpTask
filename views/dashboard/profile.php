<?php include_once __DIR__ . "/header.php"; ?>

<div class="sm-container">
    <?php include_once __DIR__ . "/../templates/alerts.php"; ?>

    <a href="/change-password" class="link">Change Password</a>

    <form class="form" action="/profile" method="POST">
            <div class="field">
                <label for="name">Name</label>
                <input type="text" id="name" placeholder="Your Name" name="name" value="<?php echo $user->name; ?>">
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Your Email" name="email" value="<?php echo $user->email; ?>">
            </div>

            <input type="submit" class="button" value="Save Changes">
    </form>
</div>

<?php include_once __DIR__ . "/footer.php"; ?>