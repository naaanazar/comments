<?php if (isset($_SESSION['username'])) :?>
    <form action="" method="post" id="sendCommentForm">
        <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea class="form-control comment-field" name="comment" rows="3" id="commentField"></textarea>
            <input type="hidden" name="userId" value="<?= isset($_SESSION['users_id']) ? $_SESSION['users_id'] : ''?>">
            <input type="hidden" name="contentId" value="<?= isset($contentId) ? $contentId : '' ?>">
            <button type="submit" class="btn btn-success btn-xs" id="sendCommentButton" >Write comment</button>
        </div>
    </form>
<?php endif; ?>

<div class="comments-list-container" data-content-id="<?= $_COOKIE["contentId"] ?>">

</div>