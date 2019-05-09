<?php include_once __DIR__ . '/layout/_layout_top.php';

$entry_id = $_GET['eid'];
$entry = null;
$categories = null;
$tags = null;
if ($entry_id) {
  $entry = get_entry_by_id(intval($entry_id));
  $categories = $entry['categories'];
  $categories = explode(';', $categories);
  $tags = $entry['tags'];
  $tags = explode(';', $tags);
}

$user = getUser();

?>

<div class="main">
  <div class="container">
    <?php if ($entry): ?>
    <section class="content">
      <?php if ($categories and sizeof($categories)): ?>
      <div class="head">
        <h1><?= $categories[0] ?></h1>
      </div>
      <?php endif; ?>
      <article class="article">
        <div class="person">
          <img src="assets/img/avatar/<?= $entry['created_by'] ?>.jpg" alt=""/>
          <h3><?= $entry['name'] ?> <?= $entry['surname'] ?></h3>
          <p><?= $entry['job_title'] ?></p>
        </div>
        <div class="text">
          <h2><?= $entry['title'] ?></h2>
          <p><?= $entry['content'] ?></p>
          <?php if ($tags and sizeof($tags)): ?>
          <p>
            <?php foreach ($tags as $tag): ?>
            <span>
              <!-- TODO: Styling -->
              <a href="/search-result.php?tag=<?= urlencode($tag) ?>"><?= $tag ?></a>
            </span>
            <?php endforeach; ?>
          </p>
          <?php endif; ?>

          <?php if ($user and ($user['id'] != $entry['created_by'])): ?>
          <div class="like">
            <button class="active">Like</button>
          </div>
          <?php endif; ?>
        </div>
      </article>
    </section>

    <?php else: ?>
      <!-- TODO: NOT FOUND -->
    <?php endif; ?>

    <?php include_once __DIR__ . '/layout/_sidebar.php'; ?>
  </div>
</div>

<?php include_once __DIR__ . '/layout/_layout_bottom.php'; ?>
