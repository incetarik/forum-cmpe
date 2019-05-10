<?php

require_once __DIR__ . '/helpers/commons.php';
$user = get_user();

?>
<header>
  <div class="container">
    <div class="logo" id="logo">
      <a href="index.php">EEEN <span>FORUM</span></a>
    </div>
    <div class="search">
      <form action="search-result.php">
        <div class="form-group">
          <input type="text" placeholder="Search">
          <button type="button">Now</button>
        </div>
      </form>
    </div>
    <div class="user">
      <?php if (!$user): ?>
        <button type="button" data-target="/login.php">Login</button>
        <button type="button" data-target="/register.php">Register</button>
      <?php else: ?>
        <button type="button" data-target="/profile.php">Profile</button>
        <button type="button" data-target="/logout.php">Log Out</button>
      <?php endif ?>
    </div>
  </div>
  <div class="container">
    <div class="menu" id="menu">
      <nav>
        <a href="index.php">Home</a>
        <a href="categories.php">Categories</a>
        <a href="content.php">Content</a>
        <a href="message.php">Message</a>
        <?php if ($user): ?>
        <a class="right" href="create-article.php">Add New</a>
        <?php endif; ?>
      </nav>
    </div>
  </div>
</header>
