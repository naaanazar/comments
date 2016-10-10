
    <form action="" method="post" id="sendCommentForm">
        <div class="form-group">           
            <textarea class="form-control comment-field" name="comment" rows="3" id="commentField"></textarea>
            <input type="hidden" name="userId" value="<?= isset($_SESSION['users_id']) ? $_SESSION['users_id'] : ''?>">
            <input type="hidden" name="contentId" value="<?= isset($contentId) ? $contentId : '' ?>">
            <button type="submit" class="btn btn-success btn-xs <?= isset($_SESSION['users_id']) ? '' : 'disabled' ?>" id="sendCommentButton" >Write comment</button>
        </div>
    </form>


<div class="comments-list-container" data-content-id="<?= $contentId ?>">

</div>