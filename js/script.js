$(function() {
    ajaxForm();
});

function ajaxForm() {

    $('.js-form').on('submit', function(e) {

        e.preventDefault();
        
        var form = $(this);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success: function (resp) {
                form.find('.l-resp').html(resp);
            }
        });

    });
}