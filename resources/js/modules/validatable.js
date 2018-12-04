/**
 * Validates forms using async ajax request and shows validation errors without page reload.
 */
$(function() {
    let $forms = $('form.validatable');
    let isValid = false;

    $forms.on('submit', function (event) {
        if(isValid) {
            return true;
        }

        event.preventDefault();

        let $form = $(event.target);
        let data = $form.serializeArray();
        data.push({name: 'validation', value: 1});

        $form.find('.form-control').removeClass('is-invalid');
        $form.find('.invalid-feedback').remove();
        $form.find('button[type="submit"]').addClass('loading disabled').attr('disabled', 'disabled');

        let request = $.ajax({
            type: 'POST',
            url: $form.attr('action'),
            data: data,
            headers: {
                Accept: "application/json; charset=utf-8",
            }
        });

        request.done(function() {
            isValid = true;

            $form.submit();
        });

        request.fail(function (request) {
            setTimeout(function() {
                let errors = request.responseJSON.errors;
                let offset = 0;
                let $highestElement = $form;

                for (let field in errors) {
                    if (errors.hasOwnProperty(field)) {
                        let fieldErrors = errors[field];

                        if( field.indexOf( '.' ) > -1 ) {
                            field = field.replace( '.', '[' ) + ']';
                        }

                        let $input = $form.find('[name="' + field + '"]');

                        if( $input.length ) {
                            $input.addClass('is-invalid');
                            let $formGroup = $input.parent( '.form-group' );
                            $formGroup.append('<span class="invalid-feedback" role="alert">' + fieldErrors[0] + '</span>');

                            if( !offset || $formGroup.offset().top < offset ) {
                                offset = $formGroup.offset().top;
                                $highestElement = $formGroup;
                            }
                        }
                    }
                }

                $(window).scrollTo($highestElement, 500);
                $form.find('button[type="submit"]').removeClass('loading disabled').removeAttr('disabled');
            }, 500);
        });
    })
});