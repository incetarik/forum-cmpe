<?php include_once __DIR__ . '/layout/_layout_top.php';

redirect_to_login_if_not_logged_in();

?>

<div class="container">
    <div class="entry">
        <form action="/api/sidebar_contents.php?f=create" method="post">
            <div class="entry-head">
                <h1>Enter new sidebar post</h1>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title">
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content"></textarea>
            </div>
            <div class="form-group">
                <button class="save" type="submit">Publish</button>
                <div class="clearfix"></div>
            </div>
        </form>
    </div>
</div>

<?php include_once __DIR__ . '/layout/_layout_bottom.php'; ?>
