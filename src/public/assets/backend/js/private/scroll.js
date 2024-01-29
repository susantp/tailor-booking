var base_url = $('#backend_folder').val();
var public_url = $('#public-url').val();
var admin_base_url = $('#base-url').val();
var admin_module = $('#admin-module').val();
var slug_error = 0;
$(document).ready(function () {
    $("[name='type_id']").change(function () {
        var cat_type_value = $(this).val();
        getCategoryDropDown(cat_type_value);

    });
});



function getCategoryDropDown(selected_type) {
    $.ajax({
        url: site_url('/shell/scroll/getProductDrop'),
        type: "post",
        data: {'selected_type': selected_type},
        success: function (result) {
            var obj = JSON.parse(result);
            $('[name="product_id"]').html(obj.html);
        },
    });
}


