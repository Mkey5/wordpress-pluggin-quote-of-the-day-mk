(function ($) {
    $(function () {
        // for alerting of the quote length
        $('.quote-mk-text').bind('input',function () {
            $('.quote-mk-length-of-text').empty();
            $('.quote-mk-length-of-text').append("Quote max length:140 | Current text length: <span class='q-mk-red'>"+ $('.quote-mk-text').val().length +"</span>");

        });
    });
})(jQuery);