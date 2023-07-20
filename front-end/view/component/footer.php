<?php include_once('./back-end/sys/sessionlogin.php'); ?>

<div class="menu-bottom mt-3">
    <ul>
        <li><a href="<?= $baseURL ?>/list"><i class="bi bi-house d-block"></i>Home</a></li>
        <li><a href="<?= $baseURL ?>/map-search"><i class="bi bi-pin-map-fill d-block"></i>Map Search</li>
        <?php
        if ($role == "admin") {
        ?>
            <li><a href="<?= $baseURL ?>/list-admin"><i class="bi bi-view-stacked d-block"></i>List RTH</li>
            <li><a href="<?= $baseURL ?>/setting"><i class="bi bi-gear d-block"></i>Setting</li>
        <?php
        } else if ($role == "user" && $_SESSION['username'] !== "Anonymouse") {
        ?>
            <li><a href="<?= $baseURL ?>/profile"><i class="bi bi-person d-block"></i>Profile</li>
        <?php }
        ?>
    </ul>
</div>
</div>