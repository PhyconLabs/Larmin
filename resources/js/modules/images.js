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

    $('.gallery .custom-file-input').change(function() {
        let input = this;
        let $parent = $(this).parents('.custom-file');

        if (input.files && input.files[0]) {
            let fileCount = input.files.length;

            if( fileCount > 3 ) {
                $parent.find('.custom-file-label').text(input.files.length + ' files chosen');
            } else if( fileCount > 1 ) {
                let fileNames = '';

                for (let key in input.files) {
                    if( input.files.hasOwnProperty( key ) ) {
                        fileNames = fileNames + input.files[key].name + ', ';
                    }
                }

                $parent.find('.custom-file-label').text(fileNames.slice(0,-2));
            } else if( fileCount === 1 ) {
                $parent.find('.custom-file-label').text(input.files[0].name);
            } else {
                return false;
            }
        }
    });

    $('.gallery .remove-image').on('click', function(event){
        event.preventDefault();
        let $card = $(event.target).parents('.gallery-image').remove();
    });

    $('.gallery .row').sortable({
        revert: true
    });
});