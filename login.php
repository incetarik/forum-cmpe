<?php $skip_header = true; include_once __DIR__ . '/layout/_layout_top.php'; ?>

<section class="login">
  <form action="#">
    <h1>Login</h1>
    <a class="go-back" href="/">Go Back</a>
    <div class="form-group">
      <label>
        ID <input type="text" placeholder="ID">
      </label>
    </div>
    <div class="form-group">
      <label>
        Password <input type="password" placeholder="Password">
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
