$(document).on("keyup", ".title", function () {
    var txtValue = $(this).val();
    var newValue = txtValue.toLowerCase().replace(/[~!@#$%\^\&\*\(\)\+=|'"|\?\/;:.,<>\-\\\s]+/gi, '-');
    $('.alias').val(newValue);
});