/**
 * Switches all i18n tabs to the same language.
 */
$(function () {
    $(document).on('click', '.i18n-field .switcher .language', function (event) {
        let $switchers = $('.i18n-field .switcher');
        let $language = $(event.target).closest('.language');
        let $languageIndex = $language.index();

        $switchers.each(function (index, element) {
            $(element).find('.language').eq($languageIndex).find('a').tab('show');
        });
    });
});