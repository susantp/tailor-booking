(function () {
    'use strict';

    var mediaTypeSelect = $('.mediaTypeSelect'),
            selectImages = $('#selectImages');

    mediaTypeSelect.on('click', function () {
        var that = $(this),
                selectedMedia = that.val();

        if (selectedMedia == 'video') {
            selectImages.hide();
            selectVideos.show();
        } else {
            selectVideos.hide();
            selectImages.show();
        }
    });

    var counter = 0;
    $('.add-images').on('click', function (e) {
        e.preventDefault();
        var that = $(this);
        counter = $(this).attr('data-counter');
        var pull = 'col-lg-6 col-md-3';
        $('.add-images').attr('data-counter', counter);
        var field = '<div class="mediaWrapper col-lg-6 col-md-3"><div class="row"><div class="col-md-4">';
        field += '<img class="img-responsive img' + counter + '" src="">';
        field += '</div><div class="col-md-8"><div class="form-group">';
        field += '<input data-rec="photo" id="image_gallery' + counter + '" data-img="img' + counter + '"  type="text" onclick="BrowseServer(this)" data-resource-type="image" data-multiple="false" name="image[]" value="" class="form-control"  placeholder="File" data-validation="required">';
        field += '</div><div class="form-group"><input class="form-control" placeholder="Title"  value="" name="title[]" data-validation="required"/></div>';
        field += '<div class="form-group"><input class="form-control" placeholder="Display Order"  value="" name="ordering[]" data-validation="required"/></div>';
        field += '<div class="form-group"><textarea class="form-control" placeholder="Description" name="content[]" data-validation="required"></textarea></div>';
        field += '</div></div><a href="javascript:void(0);" class="deleteMedia" onclick="deletePhoto(this)">Delete</a></div>';
        $('#selectImages').append(field);
        counter++;
        $(this).attr('data-counter', counter);
        // $('#image_gallery'+counter).focus;
        // counter++;
    });

    $('.deleteMedia').on('click', function (e) {
        e.preventDefault();
        var that = $(this);
        var numItems = $('.mediaWrapper').length;
        if (numItems > 1) {
            $.ajax({
                url: that.data('url'),
                success: function (res) {
                    if (res)
                        that.parents('.mediaWrapper')
                                .fadeOut('slow', function () {
                                    $(this).remove();
                                });
                }
            });
        } else {
            alert('Atleast one photo is required');
            return false;
        }
    });

})();

function deletePhoto(el) {
    var that = $(el);
    var numItems = $('.mediaWrapper').length;
    //# perhaps ajax call is required to check if the user session is still active or not.
    if (numItems > 1) {
        $.ajax({
            url: that.data('url'),
            success: function (res) {
                if (res)
                    that.parents('.mediaWrapper')
                            .fadeOut('slow', function () {
                                $(this).remove();
                            });
            }
        });
    } else {
        alert('At least one image is required in gallery.');
        return false;
    }
}
