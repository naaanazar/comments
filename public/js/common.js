$(document).ready(function () {    
    
    commentsList();
    

    
    $('#sendCommentForm').submit(function (e) {
        e.preventDefault();        

        $.ajax({
            type: "post",
            url: '/comments/insert-comment',
            data: $('#sendCommentForm').serialize(),
            success: function (data) {
                $('#commentField').val('');
                
                commentsList(); 
            }           
        });
    });
    
//    /auth/sing-out
//    $(document).on("click", '.sing-out' , function (e) {
//        e.preventDefault();        
//       
//        $.get('/auth/sing-out', function () {
//            
//        });
//    });


    
    
    $(document).on("submit", '#sendReplyForm' , function (e) {    
        e.preventDefault();        

        $.ajax({
            type: "post",
            url: '/comments/insert-comment',
            data: $('#sendReplyForm').serialize(),
            success: function (data) {
                $('#commentField').val('');
                
                commentsList(); 
            }           
        });
    });
    
    $(document).on("submit", '#editForm' , function (e) {    
        e.preventDefault();           

        $.ajax({
            type: "post",
            url: '/comments/update-comment',
            data: $('#editForm').serialize(),
            success: function (data) {    
                commentValue = $(e.target).closest('form').find('.editComentsValue').val()
                $(e.target).closest('.comments-list-body-container').find('.comments-list-body').html(commentValue)
                closeEditForm(e);
            }           
        });
    });
    
    $(document).on("click", '.reply-button' , function (e) {
        e.preventDefault();
        var id;
        $(e.target).closest('li').find('.comments-list-footer').hide();
        
        $.get('/comments/get-session', function (id) {
            parentId = $(e.target).data('comment-id');            
            var contentId = $('.comments-list-container').data('content-id');
            var html = '' +
            '<ul class="ul-form">' + 
                '<li>' + 
                    '<form action="" method="post" id="sendReplyForm">' +
                        '<div class="form-group">' +
                            '<a href="#" class="btn reply-back  btn-xs"><span class="glyphicon glyphicon-menu-left">' +
                                '</span><span class="glyphicon glyphicon-menu-left"></span> Back' +
                            '</a>' +   
                            '<textarea class="form-control" name="comment" rows="3" id="commentField"></textarea>' +
                            '<input type="hidden" name="userId" value="' + id + '">' +
                            '<input type="hidden" name="contentId" value="' + contentId + '">' +
                            '<input type="hidden" name="parentId" value="' + parentId + '">' +
                            '<button type="submit" class="btn btn-success btn-xs" id="sendCommentButton" >Write comment</button>' +
                        '</div>' +
                    '</form>' +
                '</li>' +
            '</ul>';
            
            $(e.target).closest('li').append(html); 
        });
    });
    
    $(document).on("click", '.edit-back' , function (e) {   
       closeEditForm(e);       
    });
    
    $(document).on("click", '.reply-back' , function (e) {   
       $(e.target).closest('.ul-comment-content').find('.comments-list-footer').show();
       $(e.target).closest('.ul-comment-content').find('#sendReplyForm').remove();
       
       
    });
    
    $(document).on("click", '.edit-button' , function (e) {    
    
        e.preventDefault();
        var id;
        var commentId = $(e.target).data('comment-id');
        
        $.get('/comments/get-session', function (id) {            
            $(e.target).closest('li').find('.comments-list-body').hide();
            $(e.target).closest('li').find('.comments-list-footer').hide();            
            
            var html = '' +
            '<ul class="ul-form">' + 
                '<li>' + 
                    '<form action="" method="post" id="editForm">' +
                        '<div class="form-group">' +
                            '<a href="#" class="btn edit-back  btn-xs"><span class="glyphicon glyphicon-menu-left">' +
                                '</span><span class="glyphicon glyphicon-menu-left"></span> Back' +
                            '</a>' +                            
                            '<textarea class="form-control editComentsValue" name="comment" rows="3" id="commentField"></textarea>' +
                            '<input type="hidden" name="id" value="' + commentId + '">' +                           
                            '<button type="submit" class="btn btn-success btn-xs" id="editCommentButton" >Edit comment</button>' +
                        '</div>' +
                    '</form>' +
                '</li>' +
            '</ul>';      
    
            $(e.target).closest('li').find('.comments-list-body-container').append(html); 
        });
    });  
    
    $(document).on("click", '.delete-button' , function (e) {
        e.preventDefault();
        var commentId = $(e.target).data('comment-id');
        
        $.post('/comments/delete-comment', {'id': commentId}, function (data) {
            parentId = $(e.target).data('comment-id');  
            $(e.target).closest('li').next('ul').remove();
            $(e.target).closest('li').remove();
        });
    });
    
    $(document).on("click", '.up-button' , function (e) {
        e.preventDefault();
        var id = $(e.target).closest('.comments-list-footer').data('comment-id');
        console.log(id);
        
        $.post('/comments/set-rating', {'id': id, 'rating': 'up'}, function (data) {
            
        });
    });
    
    $(document).on("click", '.down-button' , function (e) {
        e.preventDefault();
        var id = $(e.target).closest('.comments-list-footer').data('comment-id');
        console.log(id);
        
        $.post('/comments/set-rating', {'id': id, 'rating': 'down'}, function (data) {
            
        });
    });
});
var htmlCommentsTree;

function closeEditForm(e)
{
    $(e.target).closest('.comments-list-body-container').find('.comments-list-body').show();
    $(e.target).closest('.ul-comment-content').find('.comments-list-footer').show();
    $(e.target).closest('.comments-list-body-container').find('.ul-form').remove();
}

function commentsList()
{
    contentId = $('.comments-list-container').data('content-id');
    
    $.get("/comments/select-comments?contentsId=" + contentId, function (response) {
        data = $.parseJSON(response);   
        var sortComments = [];
        
        Object.keys(data.data).sort().reverse().forEach(function(v, i) {          
            sortComments[i] = data.data[v];
        });
               
        $.get('/comments/get-session', function (response) {
            htmlCommentsTree = '';           
            createCommentsTree(sortComments, response);
            
            $('.comments-list-container').html(htmlCommentsTree);
        });
    }); 
}

function checkVariable(variable) {
    if (variable !== undefined) {

        return variable;
    } else {
        
        return '';
    }
};

function createCommentsTree(data, userId) 
{
    
    var item;
    htmlCommentsTree +='<ul class="ul-comment-content">';  
    
    for (item in data) {    
        
        if (typeof(data[item]) === 'object') {
            htmlCommentsTree += '' +
            '<li>' +
                '<div class="comments-list-heder">' +
                    '<h5><a href=""><b>' + data[item]['username'] + '</b></a> . <small>' + data[item]['date'] + '</small><h5>' +
                '</div>' +
                '<div class="comments-list-body-container">' +
                    '<div class="comments-list-body">' +
                        data[item]['comment'] +
                    '</div>' +
                '</div>' +
                '<div class="comments-list-footer"  data-comment-id="' + data[item]['id'] + '">'+
                    
                    '<a href="#" class="btn up-button  btn-xs" >' +
                        '<span class="glyphicon glyphicon-thumbs-up"></span>' +
                    '</a><small>3</small>' +                    
                    '<a href="#" class="btn down-button  btn-xs" >' +
                        '<span class="glyphicon glyphicon-thumbs-down"></span>' +
                    '</a><small>3</small>';
      
                    if (userId !== 'null' ){
                        htmlCommentsTree += '' +
                        '<a href="#" class="btn reply-button  btn-xs" data-comment-id="' + data[item]['id'] + '">' +
                            'Reply <span class="glyphicon glyphicon-envelope"></span>' +
                        '</a>';
                    }
            
                    if (userId == data[item]['user_id'] ){
                        htmlCommentsTree += '' +
                        '<a href="#" class="btn  edit-button  btn-xs" data-comment-id="' + data[item]['id'] + '">' +
                            'Edit <span class="glyphicon glyphicon-edit"></span>' +
                        '</a>' + 
                        '<a href="#" class="btn delete-button  btn-xs" data-comment-id="' + data[item]['id'] + '">' +
                            'Delete <span class="glyphicon glyphicon-remove"></span></a>';
                    }
                    htmlCommentsTree += '' +
                '</div>' +
            '</li>';              
            createCommentsTree(data[item], userId);      
        }
      }
    htmlCommentsTree += '</ul>';
}



