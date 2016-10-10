$(document).ready(function () {    
    
    commentsList();
    
    $(document).on("click", '.edit-back' , function (e) {   
       closeEditForm(e);       
    });
    
    $(document).on("click", '.reply-back' , function (e) {   
       $(e.target).closest('.ul-comment-content').find('.comments-list-footer').show();
       $(e.target).closest('.ul-comment-content').find('#sendReplyForm').remove();
       
       
    });
    
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
                            '<textarea class="form-control comment-field" name="comment" rows="3" id="commentField"></textarea>' +
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
                            '<textarea class="form-control comment-field editComentsValue" name="comment" rows="3" id="commentField"></textarea>' +
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
       setRating(data,'up' , e)  
    });
    
    $(document).on("click", '.down-button' , function (e) {
        e.preventDefault();
        setRating(data,'down' , e)        
    });
});
var htmlCommentsTree;

function setRating(data, rating, e){
    var id = $(e.target).closest('.comments-list-footer').data('comment-id');
    var userId = $(e.target).closest('.comments-list-footer').data('user-id');
    
    $.post('/comments/set-rating', {'id': id, 'rating': rating, 'userId': userId}, function (data) {
        
        if (data != 'false'){
            var ratingUp = +$(e.target).closest('.comments-list-footer').find('.up-rating').text();
            var ratingDown = +$(e.target).closest('.comments-list-footer').find('.down-rating').text();
            data = $.parseJSON(data);
            console.log(data.up);
            $(e.target).closest('.comments-list-footer').find('.up-rating').text(ratingUp + data['up']);
            $(e.target).closest('.comments-list-footer').find('.down-rating').text(ratingDown + data['down']);
        }
    });
}

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
            if (data[item]['up'] == 0){
                data[item]['up'] = '';            
            }

            if (data[item]['down'] == 0){
                data[item]['down'] = '';            
            }
            var disabled = ''
            if (userId == data[item]['user_id']) {
                disabled = 'disabled';
            }

            if (typeof(data[item]) === 'object') {
                htmlCommentsTree += '' +
                '<li>' +
                    '<div class="comment-block">' +
                        '<div class="comments-list-heder">' +
                            '<h5><a href=""><b>' + data[item]['username'] + '</b></a> . <small>' + data[item]['date'] + '</small></h5>' +
                        '</div>' +
                        '<div class="comments-list-body-container">' +
                            '<div class="comments-list-body">' +
                                data[item]['comment'] +
                            '</div>' +
                        '</div>' +
                        '<div class="comments-list-footer" data-user-id="' + data[item]['user_id'] + '" data-comment-id="' + data[item]['id'] + '">'+                    
                            '<a href="#" class="btn up-button  btn-xs " >' +
                                '<span class="glyphicon glyphicon-thumbs-up"></span>' +
                            '</a><small>+<span class="up-rating">' + data[item]['up']  + '</span></small>' +                    
                            '<a href="#" class="btn down-button  btn-xs" >' +
                                '<span class="glyphicon glyphicon-thumbs-down"></span>' +
                            '</a><small>-<span class="down-rating">' + data[item]['down'] + '</span></small>';

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
                                    'Delete <span class="glyphicon glyphicon-remove"></span>' +
                                '</a>';
                            }

                            htmlCommentsTree += '' +
                        '</div>' +
                    '</div>' +                    
                '</li>';              
                createCommentsTree(data[item], userId);      
            }
        }
        htmlCommentsTree += '</ul>';
    
}



