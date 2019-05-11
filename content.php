<?php include_once __DIR__ . '/layout/_layout_top.php';

$entry_id = null;
$entry = null;
$categories = null;
$tags = null;
$userLiked = false;
$comments = [];

if (isset($_GET['eid'])) {
    $entry_id = $_GET['eid'];
}

if ($entry_id) {
    $entry = get_entry_by_id(intval($entry_id));
    $categories = $entry['categories'];
    $categories = explode(';', $categories);
    $tags = $entry['tags'];
    $tags = explode(';', $tags);
    $userLiked = get_has_user_liked_entry($user['id'], $entry['id']);
    $comments = get_comments_of_entry($entry['id']);
}

?>

<div class="main">
  <div class="container">
      <?php if ($entry): ?>
        <section class="content">
          <!-- TODO: LIKE COUNT -->
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
                    <button id="like_button_<?= $entry['id'] ?>" class="active"
                            onclick="Entry.toggleLike(<?= $entry['id'] ?>)">
                        <?= $userLiked ? 'Dislike' : 'Like' ?>
                    </button>
                  </div>
                <?php endif; ?>
            </div>
              <?php foreach ($comments as $comment): ?>
                <article class="article">
                  <div class="person">
                    <img src="/assets/img/avatar/<?= $comment['userid'] ?>.jpg"
                         alt="<?= $comment['name'] ?> <?= $comment['surname'] ?>"/>
                    <h3><?= $comment['name'] ?> <?= $comment['surname'] ?></h3>
                    <p><?= $comment['job_title'] ?></p>
                  </div>
                  <div class="text">
                      <?php if (isset($comment['title']) && $comment['title']): ?>
                        <h2><?= $comment['title'] ?></h2>
                      <?php endif; ?>
                    <p><?= $comment['content'] ?></p>
                  </div>
                </article>
              <?php endforeach; ?>
              <?php if (isset($user) and $user): ?>
                <article class="article reply">
                  <form action="#">
                    <h1>Enter message title and the content</h1>
                    <div class="form-group">
                      <input type="text" placeholder="Message Title" name="title" id="title">
                    </div>
                    <div class="form-group">
                      <textarea placeholder="Message Content" name="content" id="content"></textarea>
                    </div>
                    <p>Defamation, racism, religion, language, the separation of the region, including politics,
                      manipulation, humiliation messages will not be allowed, and those who make such shares will be
                      followed by our system and their membership will be canceled.</p>
                    <a class="send" id="reply" href="javascript:Entry.addComment(title.value, content.value, <?=
                    $entry['id']
                    ?>, <?=
                    $user['id']
                    ?>, '<?=
                    $user['name'] . ' ' . $user['surname']
                    ?>', '<?=
                    $user['job_title']
                    ?>')"
                       type="button">Send</a>
                  </form>
                </article>
              <?php endif; ?>
          </article>
        </section>

      <?php else: ?>
        <!-- TODO: NOT FOUND -->
      <?php endif; ?>

      <?php include_once __DIR__ . '/layout/_sidebar.php'; ?>
  </div>
</div>

<script src="/assets/js/entry.js"></script>
<?php include_once __DIR__ . '/layout/_layout_bottom.php'; ?>
