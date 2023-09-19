<div class="container create">
    <?php include_once __DIR__ . "/../templates/site-name.php"; ?>

    <div class="sm-container">
        <p class="page-description">Create your account in UpTask</p>

        <?php include_once __DIR__ . "/../templates/alerts.php"; ?>

        <form action="/create-account" class="form" method="POST">
            <div class="field">
                <label for="name">Name</label>
                <input type="text" id="name" placeholder="Your Name" name="name" value="<?php echo $user->name; ?>">
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Your Email" name="email" value="<?php echo $user->email; ?>">
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Your Password" name="password">
            </div>

            <div class="field">
                <label for="rpassword">Repeat Password</label>
                <input type="password" id="rpassword" placeholder="Repeat your Password" name="rpassword">
            </div>

            <input type="submit" class="button" value="Create Account">
        </form>

        <div class="actions">
            <a href="/">You already have an account? Log In</a>
            <a href="/forgot-password">Forgot your password?</a>
        </div>
    </div>
</div>