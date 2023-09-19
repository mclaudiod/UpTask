<div class="container login">
    <?php include_once __DIR__ . "/../templates/site-name.php"; ?>

    <div class="sm-container">
        <p class="page-description">Log In</p>

        <?php include_once __DIR__ . "/../templates/alerts.php"; ?>

        <form action="/" class="form" method="POST">
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Your Email" name="email">
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Your Password" name="password">
            </div>

            <input type="submit" class="button" value="Log In">
        </form>

        <div class="actions">
            <a href="/create-account">You don't have an account yet? Create one</a>
            <a href="/forgot-password">Forgot your password?</a>
        </div>
    </div>
</div>