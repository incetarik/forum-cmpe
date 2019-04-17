<?php include_once __DIR__ . '/layout/_layout_top.php';

redirectToLoginIfNotLoggedIn();
?>

<div class="profile-page">
    <h2 class="username"><?= $user['name'] ?> <?= $user['surname'] ?> <?= $user['email_address'] ?></h2>
</div>

<?php include_once __DIR__ . '/layout/_layout_bottom.php'; ?>
