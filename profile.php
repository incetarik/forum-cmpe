<?php include_once __DIR__ . '/layout/_layout_top.php';

redirect_to_login_if_not_logged_in();
$validation = $_SESSION['__update_form_validation'] = gen_uuid();

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
      <input type="hidden" value="<?= $validation ?>"/>
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" placeholder="<?= $user['name'] ?>" minlength="3" onchange="UpdateProfile.updateButton()">
      </div>
      <div class="form-group">
        <label for="surname">Surname:</label>
        <input type="text" id="surname" placeholder="<?= $user['surname'] ?>" minlength="2" onchange="UpdateProfile.updateButton()">
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" placeholder="<?= $user['email_address'] ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" onchange="UpdateProfile.updateButton()">
      </div>
      <div class="form-group">
        <label for="jobTitle">Job:</label>
        <input type="text" id="jobTitle" placeholder="<?= $user['job_title'] ?>" pattern="\w[\w \d]*" onchange="UpdateProfile.updateButton()">
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" placeholder="••••••••" minlength="6" onchange="UpdateProfile.updateButton()">
      </div>
      <div class="form-group">
        <button type="button" id="saveButton">Save</button>
      </div>
    </form>
  </div>
</div>

<script id="removeMe">var defaultValues={name:'<?=
            $user['name'] ?>',surname:'<?=
            $user['surname'] ?>',email:'<?=
            $user['email_address'] ?>',jobTitle:'<?=
            $user['job_title']
?>'}</script>
<script src="/assets/js/update-profile.js"></script>
<?php include_once __DIR__ . '/layout/_layout_bottom.php'; ?>
