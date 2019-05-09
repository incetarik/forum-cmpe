<?php include_once __DIR__ . '/layout/_layout_top.php';

$tag = null;
$uid = null;
$entries = null;

if (isset($_GET['tag'])) {
  $tag = $_GET['tag'];
}

if (isset($_GET['uid'])) {
  $uid = $_GET['uid'];
  $entries = get_entries_sent_by_user(intval($uid));
}

?>
  <div class="main search-result-container">
    <div class="container">
      <div class="search-result-title">
        <h1>
          Search Results
            <?php
            if ($uid) {
              echo ' by user: "' . get_user_full_name($uid) . '"';
            }
            else if ($tag) {
              echo ' by tag: "' . $tag . '"';
            }
            ?>
        </h1>
      </div>
    </div>
    <div class="container">
      <?php if ($entries and sizeof($entries)): ?>
          <?php foreach ($entries as $entry) {
            $categories = $entry['categories'] or '';
            $categories = explode(';', $categories);
            $tags = $entry['tags'] or '';
            $tags = explode(';', $tags); ?>

            <section class="content">
              <?php if ($categories and sizeof($categories)): ?>
              <div class="head">
                <h1><?= $categories[0] ?></h1>
                <button type="button">more...</button>
              </div>
              <?php endif; ?>
              <article>
                <a href="/content.php?eid=<?= $entry['id'] ?>">
                  <h2><?= $entry['title'] ?></h2>
                  <p><?= substr($entry['content'], 0, 70) ?></p>
                </a>
                <p>
                  <?php foreach ($tags as $tag): ?>
                  <a href="/search-result.php?tag=<?= urlencode($tag) ?>"><?= $tag ?></a>
                  <?php endforeach; ?>
                </p>
              </article>
            </section>
          <?php } ?>
      <?php else: ?>
      <!-- TODO: Not found any -->
      <?php endif; ?>

      <?php include_once __DIR__ . '/layout/_sidebar.php'; ?>
    </div>
  </div>

<?php include_once __DIR__ . '/layout/_layout_bottom.php'; ?>
