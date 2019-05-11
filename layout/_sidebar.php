<?php $sidebar_contents = get_sidebar_contents(); ?>

<section class="sidebar" id="sidebar">
  <?php foreach ($sidebar_contents as $sidebar_content): ?>
    <div class="head">
      <h3><?= $sidebar_content['title'] ?></h3>
      <?php if (isset($user) && $user && isset($user['id']) && $sidebar_content['added_by'] == $user['id']) {
        $guid = gen_uuid();
        if (!isset($_SESSION[SESSION_SIDEBAR_PAIRS])) {
          $_SESSION[SESSION_SIDEBAR_PAIRS] = [];
        }

        $pairs = $_SESSION[SESSION_SIDEBAR_PAIRS];
        if (!is_array($pairs)) $pairs = [];
        $pairs[$sidebar_content['id']] = [ $user['id'], $guid ];
        $_SESSION[SESSION_SIDEBAR_PAIRS] = $pairs;
        ?>

      <button
          type="button"
          id="del_sbc_<?= $sidebar_content['id'] ?>"
          onclick="Global.deleteSidebarContent(<?= $sidebar_content['id'] ?>, '<?= $guid ?>')"
      >
        Delete
      </button>

      <?php } ?>
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
