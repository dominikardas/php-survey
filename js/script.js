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
                // alert('form was submitted');
                // alert(resp);
                console.log(resp);
                form.find('.l-resp').html(resp);
            }
        });

    });
}