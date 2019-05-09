<?php include_once __DIR__ . '/layout/_layout_top.php';

$categories = get_categories();

?>

<div class="main">
  <div class="container">
    <?php foreach ($categories as $category): ?>
    <section class="content">
      <div class="head">
        <h1><?= $category ?></h1>
        <button type="button">more...</button>
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
    <?php endforeach; ?>

    <section class="sidebar" id="sidebar">
      <div class="head">
        <h3>CONTAINER</h3>
      </div>
      <article>
        <p>Lorem ipsum dolor sit amet dolorum ipsum sit amet</p>
      </article>
    </section>
  </div>
</div>

<?php include_once __DIR__ . '/layout/_layout_bottom.php'; ?>
