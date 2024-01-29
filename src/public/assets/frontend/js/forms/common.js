$(document).ready(function () {
    $(".inquiry-form").validate({
        submitHandler: function (form) {
            $('form').find("button#submit").attr("disabled", true).text("Sending...");
            $.ajax({
                url: site_url('process_form'),
                type: "post",
                data: $(form).serialize(),
                dataType: 'json',
                success: function (data) {
                    $('form').find("button#submit").attr("disabled", false).text("Send Message");
                    $('span.msg').text(data[0].msg).show().delay(3000).fadeOut();
                    if (data[0].status == 'success') {
                        $('form').find('input:text').val('');
                        $('form').find('textarea').val('');
                    }
                }
            });
            return false;
        }

    });
    $(".send-your-data-form").validate({
        submitHandler: function (form) {
            var formData = new FormData($('.send-your-data-form')[0]);
            console.log(formData);
//            $('form').find("button#submit").attr("disabled", true).text("Sending...");
            $('form').find("button#submit").text("Sending...");
            $.ajax({
                url: site_url('process_send_data_form'),
                type: "post",
                data:formData,
//                data:$(form).serialize(),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    $('form').find("button#submit").attr("disabled", false).text("Send Message");
                    $('span.msg').text(data[0].msg).show().delay(3000).fadeOut();
                    if (data[0].status == 'success') {
                        $('form').find('input:text').val('');
                        $('form').find('textarea').val('');
                    }
                }
            });
            return false;
        }

    });
});