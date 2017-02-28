$(document).ready(function() {
    $(document).scroll(function () {
        var scroll = $(this).scrollTop();
        var topDist = $(".navbar").position();
        if (scroll > topDist.top) {
            $('.container-fluid').css({"position":"fixed","top":"0"});
        } else {
            $('.container-fluid').css({"position":"static","top":"auto"});
        }
    });
});