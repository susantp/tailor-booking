/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
    config.toolbar = 'MyToolbar';
    config.height = 400;
    config.toolbar_MyToolbar =
            [
                {name: 'document', items: ['Source', 'PasteFromWord']},
                {name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll']},
                {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']},
                {name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']},
                {name: 'insert', items: ['Table', 'HorizontalRule', 'SpecialChar', 'PageBreak']},
                {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
//                '/',
                {name: 'image', items: ['Image', 'Youtube', 'Iframe', 'MediaEmbed','Flash']},
                {name: 'styles', items: ['Font','Format', 'FontSize']},
                {name: 'colors', items: ['TextColor', 'BGColor']},
                {name: 'tools', items: ['Maximize', 'ShowBlocks']}

            ];
    config.filebrowserBrowseUrl = webpath + '/backend/editor/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = webpath + '/backend/editor/ckfinder/ckfinder.html?type=Images';
    config.filebrowserFlashBrowseUrl = webpath + '/backend/editor/ckfinder/ckfinder.html?type=Flash';
};
