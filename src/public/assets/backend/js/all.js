$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})
$('document').ready(function () {
            $(".user_form").validate({
            ignore: [],
              debug: false,
                rules: { 
                    ckeditor:{
                         required: function() 
                        {
                         CKEDITOR.instances.ckeditor.updateElement();
                        },

                         minlength:10
                    }
                },
                messages:
                    {
                    ckeditor:{
                        required:"Please enter Text",
                        minlength:"Please enter 10 characters"


                    }
                }
            });
$('#datepicker').datepicker({autoclose: true, format: 'yyyy-mm-dd'});
//    $('#datepickerMonth').datepicker({dateFormat: 'yy-mm'});
//
    jQuery('.applyDataTable').dataTable({
        "iDisplayLength": 10,
        "bAutoWidth": false,
        'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': ['nosort']
            }],
        "bPaginate": true
    });


//# removes the path value of image from text box and hides image preview, previously set by elfinder 
    $('body').on('click', '.delete', function (e) {
        e.preventDefault();
        var that = $(this);
        that.parents('.image-wrapper')
                .fadeOut('slow', function () {
                    $(this).remove();
                });
        var value = that.parents('.image-wrapper').prev( );
        $(value).val('');

    });

//
//
//    $('.add_time_rows').click(function () {
//        var inc = parseInt($(this).attr('data')) + 1;
//        $('.add_time_row_data table tbody').find('label.sn').text(inc);
//        var this_tr = $('.add_time_row_data table tbody').html();
//        $(this).prev('table').find('tbody').append(this_tr);
//        $(this).attr('data', inc);
//
//    });
//
});

$()

function round(value, decimals) {
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}

/**
 * Changes the status for the given url/id
 * @param {type} selecter
 * @param {type} action_url
 * @returns {undefined}
 */
function changeStatus(selecter, action_url) {
    var _id = $(selecter).attr('id');
    var _status = $(selecter).attr('title') === 'Active' ? '1' : '0';
    var _this = $(selecter);
    var _title;
    var img_url = site_url('/assets/backend/img/loaders/loader1.gif');
    $(selecter).html('<img src="' + img_url + '" />');
    $.get((action_url + '/' + _status), {id: _id},
    function (data) {
        _this.html('<i class="fa fa-circle fa-fw"></i>');
        $(selecter).removeClass();
        if (data === '1') {
            _title = 'Active';
            _this.addClass("btn btn-success");
        } else {
            _title = 'Inctive';
            _this.addClass("btn btn-warning");
        }
        _this.attr("title", _title);
    });

}

/**
 * assigns the action url to the form
 * @param {type} url
 * @returns {Boolean}
 */
function deleteId(url) {
    $('form#confirmDelete').attr('action', url);
    return true;
}