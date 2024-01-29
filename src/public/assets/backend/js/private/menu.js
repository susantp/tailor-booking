var base_url = $('#backend_folder').val();
var public_url = $('#public-url').val();
var admin_base_url = $('#base-url').val();
var admin_module = $('#admin-module').val();
var slug_error = 0;
$(document).ready(function () {
    var menu_link_type_value = $('#menu-link-type').val();
    if (menu_link_type_value == 'url') {
        $('.url_div').show();
        $('.content_div').hide();
        $('.category_div').hide();
        $('.file_div').hide();
    }
    else if (menu_link_type_value == 'content') {
        $('.file_div').hide();
        $('.url_div').hide();
        $('.content_div').show();
        selected_category = $('#category_id').attr('data-old');
        selected_content = $('#content_id').attr('data-old');
        getCategoryDropDown(selected_category, menu_link_type_value);
        getContentDropDown(selected_category, selected_content);
    }
    else if (menu_link_type_value == 'product') {
        $('.file_div').hide();
        $('.url_div').hide();
        $('.content_div').hide();
        $('.category_div').show();
        selected_category = $('#category_id').attr('data-old');
        getCategoryDropDown(selected_category, menu_link_type_value);

    }
    else if (menu_link_type_value == 'file') {
        $('.url_div').hide();
        $('.content_div').hide();
        $('.category_div').hide();
        $('.file_div').show();

    }
    else if (menu_link_type_value == 'finance') {
        $('.file_div').hide();
        $('.url_div').hide();
        $('.content_div').hide();
        $('.category_div').show();
        selected_category = $('#category_id').attr('data-old');
        getFinanceCategoryDropDown(selected_category);

    }
    else {
        $('.url_div').hide();
        $('.content_div').hide();
        $('.category_div').hide();
        $('.file_div').hide();
    }

    $("#menu-link-type").change(function () {
        var menu_link_type_value = $(this).val();
        if (menu_link_type_value == 'content') {
            $('.file_div').hide();
            $('.url_div').hide();
            $('.content_div').show();
            $('.category_div').show();
            selected_category = '';
            selected_content = '';
            getCategoryDropDown(selected_category, menu_link_type_value);
            getContentDropDown(selected_category, selected_content);

        }
        else if (menu_link_type_value == 'product') {
            $('.file_div').hide();
            $('.url_div').hide();
            $('.content_div').hide();
            $('.category_div').show();
            selected_category = '';
            getCategoryDropDown(selected_category, menu_link_type_value);

        }
        else if (menu_link_type_value == 'url') {
            $('.file_div').hide();
            $('.url_div').show();
            $('.content_div').hide();
            $('.category_div').hide();

        }
        else if (menu_link_type_value == 'file') {
            $('.url_div').hide();
            $('.content_div').hide();
            $('.category_div').hide();
            $('.file_div').show();

        }
        else if (menu_link_type_value == 'finance') {
            $('.file_div').hide();
            $('.url_div').hide();
            $('.content_div').hide();
            $('.category_div').show();
            selected_category = '';
            getFinanceCategoryDropDown(selected_category);

        }
        else {
            $('.file_div').hide();
            $('.url_div').hide();
            $('.content_div').hide();
            $('.category_div').hide();
        }
    });

    $("#menu_name").keyup(function () {
        slug = $(this).val();
        id = $('#menu_name').attr('old_id');
        new_slug = slug.toLowerCase();
        new_slug = new_slug.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
        $('#slug').val(new_slug);
        $.ajax({
            url: site_url('/shell/menu/check_slug'),
            type: "post",
            data: {'slug': new_slug, 'id': id},
            success: function (result) {
                var obj = JSON.parse(result)
                if (obj.has_slug == true) {
                    $('#slug').parent('div').parent('div').addClass('has-error');
                    slug_error = 1;
                }
                else {
                    $('#slug').parent('div').parent('div').removeClass('has-error');
                    slug_error = 0;
                }
            },
        });
    });

    $("#slug").keyup(function () {
        id = $('#menu_name').attr('old_id');
        slug = $(this).val();
        $.ajax({
            url: site_url('/shell/menu/check_slug'),
            type: "post",
            data: {'slug': slug, 'id': id},
            success: function (result) {
                var obj = JSON.parse(result);
                if (obj.has_slug == true) {
                    $('#slug').parent('div').parent('div').addClass('has-error');
                    slug_error = 1;
                }
                else {
                    $('#slug').parent('div').parent('div').removeClass('has-error');
                    slug_error = 0;
                }
            },
        });
    });

    $("#category_id").change(function () {
        category_id = $(this).val();
        getContentDropDown(category_id, '');
    });

    $("#menu_form").submit(function (event) {
        if (slug_error == 1) {
           alert('Error, The slug already exists. Please use unique slug');
            event.preventDefault();
        }
    });
});



function getCategoryDropDown(selected_category, menu_link_type_value) {
    $.ajax({
        url: site_url('/shell/menu/getCategoryDrop'),
        type: "post",
        data: {'selected_category': selected_category, 'menu_link_type_value': menu_link_type_value},
        success: function (result) {
            var obj = JSON.parse(result);
            $('#category_id').html(obj.html);
        },
    });
}



function getContentDropDown(category_id, selected_content) {
    $.ajax({
        url: site_url('/shell/menu/getContentDrop'),
        type: "post",
        data: {'category_id': category_id, 'selected_content': selected_content},
        success: function (result) {
            var obj = JSON.parse(result);
            $('#content_id').html(obj.html);
        },
    });
}

