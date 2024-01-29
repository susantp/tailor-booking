check_cp('#chk-cp-1');
$(document).on("change", "#chk-cp-1", function () {
    check_cp('#chk-cp-1');
});
function check_cp($cp) {
    if ($($cp).prop('checked')) {
        $('[name="new_password"]').parent().show();
        $('[name="new_password_confirmation"]').parent().show();
    } else {
        $('[name="new_password"]').parent().hide();
        $('[name="new_password_confirmation"]').parent().hide();

    }
}