<?php include_once __DIR__ . '/layout/_layout_top.php'; ?>

<div class="container">
    <div class="entry">
        <div class="entry-head">
            <h1>Enter new entry info</h1>
        </div>
        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" id="title" name="title">
        </div>
        <div class="form-group">
          <label for="category">Category (separated with comma: ',')</label>
          <input type="text" id="category">
        </div>
        <div class="form-group">
          <label for="tags">Tags (separated with comma: ',')</label>
          <input type="text" id="tags">
        </div>
        <div class="form-group">
          <label for="content">Content</label>
          <textarea id="content"></textarea>
        </div>
        <div class="form-group">
          <button class="save">Publish</button>
          <div class="clearfix"></div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/layout/_layout_bottom.php'; ?>
