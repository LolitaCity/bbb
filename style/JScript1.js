$(document).ready(function () {
    if ($('.tablescroll_body tr').length < 7) {
        $('#thetable').tableScroll({
            width: 850,
            height: 325
        });
    } else {
        $('#thetable').tableScroll({
            width: 832,
            height: 325
        });
    }
});