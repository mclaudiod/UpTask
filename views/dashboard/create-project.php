<?php include_once __DIR__ . "/header.php"; ?>
    <div class="sm-container">
        <?php include_once __DIR__ . "/../templates/alerts.php"; ?>

        <form action="/create-project" class="form" method="POST">
            <?php include_once __DIR__ . "/form.php"; ?>

            <input type="submit" value="Create Project">
        </form>
    </div>
<?php include_once __DIR__ . "/footer.php"; ?>