$(document).ready(function() {
    $('a.subscribe').click(function() {
        let params = {
            'id' : $(this).attr('id')
        }
        $.post('/user/profile/subscribe', params, function(data) {
            $('a.subscribe').hide();
            $('a.unsubscribe').show();
            $('span.follower-button').html(data.followercount);
            let a = document.createElement('a');
            a.id = data['follower']['id'];
            a.href = '/user/profile/view?username=' + data.follower.username;
            a.append(data.follower.username);

            $('div.followers').append(a);

        });
        return false;
    });
});
$(document).ready(function() {
    $('a.unsubscribe').click(function() {
        let params = {
            'id' : $(this).attr('id')
        }
        $.post('/user/profile/unsubscribe', params, function(data) {
            $('a.subscribe').show();
            $('a.unsubscribe').hide();
           
            $('span.follower-button').html(data.followercount);

            $('#' + data['follower']['id']).remove();
            //$('div.followers').append(data.follower.username);
        });
        return false;
    });
});
    // $.get('/user/profile/check-subscription', {}, function(data) {
    //     if(data.subscribed) {
    //         $('.unsubscribe').hide();
    //         $('.subscribe').show();
    //     } else {
    //         $('.subscribe').hide();
    //         $('.unsubscribe').show();
    //     }
    //     return false;
    // });

    



