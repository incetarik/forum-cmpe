<?php

$skip_header = true;
include_once __DIR__ . '/layout/_layout_top.php';
redirect_user_if_logged_in( '/', true);

?>

<section class="login">
  <form action="#">
    <h1>Login</h1>
    <h3 class="error-info"></h3>
    <a class="go-back" href="/">Go Back</a>
    <div class="form-group">
      <label>
        ID <input type="text" placeholder="ID" minlength="4" pattern="[a-z][a-z1-9]{3,}">
      </label>
    </div>
    <div class="form-group">
      <label>
        Password <input type="password" placeholder="Password" minlength="6">
      </label>
    </div>
    <div class="form-group">
      <button type="button">Login</button>
    </div>
  </form>
</section>
<script src="/assets/js/login.js" type="application/javascript"></script>
</body>
</html>
