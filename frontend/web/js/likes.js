$(document).ready( function() {
    $("a.button-like").click( function() {
        let button = $(this);
        let params = { 
            'id' : $(this).attr('data-id')
        }
        $.post('/post/default/like', params, function(data) {
            $("#like").hide();
            $("#unlike").show();
            $(".likes-count").html(data.likesCount);
        });
        return false;
    });
});
$(document).ready( function() {
    $("a.button-unlike").click( function() {
        let button = $(this);
        let params = { 
            'id' : $(this).attr('data-id')
        }
        $.post('/post/default/unlike', params, function(data) {
            $("#unlike").hide();
            $("#like").show();
            $(".likes-count").html(data.likesCount);
        });
        return false;
    });
});