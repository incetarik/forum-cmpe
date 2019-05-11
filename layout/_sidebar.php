<?php $sidebar_contents = get_sidebar_contents(); ?>

<section class="sidebar" id="sidebar">
  <?php foreach ($sidebar_contents as $sidebar_content): ?>
    <div class="head">
      <h3><?= $sidebar_content['title'] ?></h3>
    </div>
    <article>
      <p><?= $sidebar_content['content'] ?></p>

      <a class="user-info" href="/search-result.php?uid=<?= $sidebar_content['added_by'] ?>">
          <?= $sidebar_content['name'] ?> <?= $sidebar_content['surname'] ?>
      </a>
    </article>
  <?php endforeach; ?>
  <?php if ($user): ?>
  <div class="head create-new">
    <h3><a href="/create-sidebar-post.php">Post New</a></h3>
  </div>
  <?php endif; ?>
</section>
