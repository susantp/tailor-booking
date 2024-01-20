var base_url = $('#backend_folder').val();
var public_url = $('#public-url').val();
var admin_base_url = $('#base-url').val();
var admin_module = $('#admin-module').val();
var slug_error = 0;
$(document).ready(function () {
//    $("[name='type']").change(function () {
//        var loc_type_value = $(this).val();
//        getParentLocationDropDown(loc_type_value);
//
//    });
    $("[name='parent_location_id']").change(function () {
        var loc_type_value = $(this).val();
        getLocationDropDown(loc_type_value);

    });
});



function getLocationDropDown(selected_type) {
    $.ajax({
        url: site_url('/shell/accommodation/getLocationDrop'),
        type: "post",
        data: {'selected_type': selected_type},
        success: function (result) {
            var obj = JSON.parse(result);
            $('[name="location_id"]').html(obj.html);
        },
    });
}
function getParentLocationDropDown(selected_type) {
    $.ajax({
        url: site_url('/shell/accommodation/getParentLocationDrop'),
        type: "post",
        data: {'selected_type': selected_type},
        success: function (result) {
            var obj = JSON.parse(result);
            $('[name="parent_location_id"]').html(obj.html);
        },
    });
}


