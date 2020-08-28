$(function() {
    ajaxForm();
});

function ajaxForm() {

    $('.js-form').on('submit', function (e) {

        e.preventDefault();
        
        var form = $(this);

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function (resp) {
                // alert('form was submitted');
                // alert(resp);
                console.log(resp);
                form.find('.l-resp').html(resp);
            }
        });

    });
}