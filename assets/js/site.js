$(function(){
    $('.mark_read').on('click', function () {
        $.post('/messages/make-read', {}, function (data) {
            if(data.success){
                message(1, 'Сообщения отмечены прочитанными');
                $('.mailbox').closest('.nav-item').find('.nav-link').click();
            }else{
                message(0, 'Ошибка');
            }
        });
        return false;
    });
});

function message(type, text, sticky)
{
    var header;

    if(type == 0 || type == 'error'){
        header = 'Ошибка!';
        type = 'error';
    }
    if(type == 1 || type == 'success'){
        header = 'Успех!';
        type = 'success';
    }
    if(type == 2 || type == 'info'){
        header = '';
        type = 'info';
    }
    if(type == 3 || type == 'warning'){
        header = 'Внимание!';
        type = 'warning';
    }

    if (!sticky) {
        sticky = false;
    }

    var params = {
        heading: header,
        text: text,
        position: 'top-right',
        loaderBg:'#ff6849',
        icon: type,
        hideAfter: 3000,
        stack: 5
    };

    if (sticky == true) {
        params.hideAfter = false;
    }

    $.toast(params);
}