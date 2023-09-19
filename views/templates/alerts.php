<?php foreach($alerts as $key => $alert):
    foreach($alert as $message): ?>
        <p class="alert <?php echo $key; ?>"><?php echo $message; ?></p>
    <?php endforeach;
endforeach; ?>