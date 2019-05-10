<?php include_once __DIR__ . '/layout/_layout_top.php';

$categories = get_categories();

?>

<div class="main">
  <div class="container">
    <?php foreach ($categories as $category) { if (!$category) continue; ?>
    <section class="content">
      <div class="head">
        <?php if ($category): ?>
        <h1><?= $category ?></h1>
        <button type="button" onclick="location.href='/search-result.php?category=<?= urlencode($category) ?>'">more...</button>
        <?php else: ?>
        <h1>Others</h1>
        <?php endif; ?>
      </div>
      <?php foreach (array_slice(get_entries_by_category($category),0, 3) as $entry): ?>
      <article>
        <a href="/content.php?eid=<?= $entry['id'] ?>">
          <h2><?= $entry['title'] ?></h2>
          <p><?= substr($entry['content'], 0, 70) ?></p>
        </a>
        <p>
          <?php if ($entry['tags'] and strlen($entry['tags'])): ?>
          <?php foreach (explode(';', $entry['tags']) as $tag): ?>
          <a href="/search-result.php?tag=<?= urlencode($tag) ?>"><?= $tag ?></a>
          <?php endforeach; ?>
          <?php endif; ?>
        </p>
      </article>
      <?php endforeach; ?>
    </section>
    <?php } ?>

    <?php include_once __DIR__ . '/layout/_sidebar.php'; ?>
  </div>
</div>

<?php include_once __DIR__ . '/layout/_layout_bottom.php'; ?>
