/**
 * Updates selected file count for file input and shows image preview.
 */
$(function () {
    $('.uploaded-image .custom-file-input').change(function() {
        let input = this;
        let $parent = $(this).parents('.uploaded-image');

        if (input.files && input.files[0]) {
            let reader = new FileReader();

            reader.onload = function(e) {
                $parent.find('.preview').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
            $parent.find('.custom-file-label').text(input.files[0].name);
        }
    });
});