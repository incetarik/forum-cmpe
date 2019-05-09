<?php include_once __DIR__ . '/layout/_layout_top.php';

redirect_to_login_if_not_logged_in();

?>

<div class="container">
  <div class="my-profile">
    <div class="img edit">
      <img src="/assets/img/avatar/<?= $user['id'] ?>.jpg" alt="" />
      <button type="button" class="change-btn">Change</button>
      <button type="button" class="save-btn">Save</button>
    </div>
    <div class="name text">
      <p><?= $user['name'] ?> <?= $user['surname'] ?></p>
    </div>
    <div class="job-title text">
      <p><?= $user['job_title'] ?></p>
    </div>
    <div class="email text">
      <p><?= $user['email_address'] ?></p>
    </div>
  </div>
  <div class="edit-profile">
    <form action="">
      <div class="form-group"><label for="name">Name:</label><input type="text" id="name"></div>
      <div class="form-group"><label for="surname">Surname:</label><input type="text" id="surname"></div>
      <div class="form-group"><label for="email">Email:</label><input type="email" id="email"></div>
      <div class="form-group"><label for="jobTitle">Job:</label><input type="text" id="jobTitle"></div>
      <div class="form-group"><button type="button">Save</button></div>
    </form>
  </div>
</div>

<?php include_once __DIR__ . '/layout/_layout_bottom.php'; ?>
