<div class="container forgot">
    <?php include_once __DIR__ . "/../templates/site-name.php"; ?>

    <div class="sm-container">
        <p class="page-description">Forgot your Password?</p>

        <?php include_once __DIR__ . "/../templates/alerts.php"; ?>

        <form action="/forgot-password" class="form" method="POST">
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Your Email" name="email">
            </div>

            <input type="submit" class="button" value="Send Instructions">
        </form>

        <div class="actions">
            <a href="/">You already have an account? Log In</a>
            <a href="/create-account">You don't have an account yet? Create one</a>
        </div>
    </div>
</div>