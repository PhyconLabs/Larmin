/**
 * Initializes TinyMCE for richtext inputs.
 */
$(function () {
    tinymce.init({
        selector: 'textarea.richtext',
        skin_url: '/css/tinymce/skins/lightgray',
        plugins: [ 'lists', 'link', 'image', 'media', 'table' ],
        toolbar: 'undo redo | styleselect | bold italic underline | bullist numlist | link unlink | table | media | image',
        images_upload_url: '/admin/upload/image',
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });
});