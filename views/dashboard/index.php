<?php include_once __DIR__ . "/header.php"; ?>
    <?php if(count($projects) === 0) { ?>
        <p class="no-projects">There are no projects yet</p>
    <?php } else { ?>
        <ul class="projects-list">
            <?php foreach($projects as $project) { ?>
                <li class="project">
                    <a href="/project?id=<?php echo $project->url; ?>">
                        <?php echo $project->project; ?>
                    </a>
                </li>
            <?php }; ?>
        </ul>
    <?php }; ?>
<?php include_once __DIR__ . "/footer.php"; ?>