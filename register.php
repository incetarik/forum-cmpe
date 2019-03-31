<?php
require_once __DIR__ . '/helpers/commons.php';

$uuid = $_SESSION['__register_form_validation'] = gen_uuid();
$skip_header = true;
include_once __DIR__ . '/layout/_layout_top.php';
redirectIfUserLoggedIn('/', true);

?>

<section class="login register">
  <form action="#">
    <input type="hidden" value="<?= $uuid ?>">
    <h1>Register Form</h1>
    <h3 class="error-info"></h3>
    <a class="go-back" href="/">Go Back</a>
    <div class="form-group">
      <label>
        ID <input type="text" placeholder="ID" minlength="4" pattern="[a-z][a-z1-9]{3,}">
      </label>
    </div>
    <div class="form-group">
      <label>
        Name <input type="text" placeholder="Name" minlength="4" pattern="[a-zA-Z]{4,}">
      </label>
    </div>
    <div class="form-group">
      <label>
        Surname <input type="text" placeholder="Surname" minlength="4" pattern="[a-zA-Z]{4,}">
      </label>
    </div>
    <div class="form-group">
      <label>
        Mail <input type="email" placeholder="Mail" minlength="4">
      </label>
    </div>
    <div class="form-group">
      <label>
        Password <input type="password" placeholder="Password" minlength="6">
      </label>
    </div>
    <div class="form-group">
      <label>
        Password (again) <input type="password" placeholder="Password (again)" minlength="6">
      </label>
    </div>
    <div class="form-group">
      <button type="button">Register</button>
    </div>
  </form>
</section>
<script src="assets/js/register.js" type="application/javascript"></script>
</body>
</html>
