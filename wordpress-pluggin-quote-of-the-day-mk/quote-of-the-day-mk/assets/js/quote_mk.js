(function ($) {
    $(function () {

        $(".continue-button-quote-mk").click(function () {
            $(".quote-mk-wrapper").addClass("hidden");
        });

        // Check if user did visit the site today
        if (typeof $.cookie("quote-of-day-mk") === "undefined") {
            //no cookie
            $(".quote-mk-wrapper").removeClass("hidden");
            $.cookie("quote-of-day-mk", 1, {expires: 1});
        }
    });
})(jQuery);