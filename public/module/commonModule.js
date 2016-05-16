jQuery(document).ready(function (jQuery) {
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function (xhr) {
            jQuery("#loaderDiv").css({
                "display": "block"
            });
        },
        error: function (x, status, error) {
            if (x.status == 401) {
                alert("Sorry, your session has expired. Please login again to continue");
                window.location.href = "/auth/login";
            }

            if (x.status == 403) {
                alert("You are not authorized for this");
                //window.location.href = "/auth/login";
            } else {
                alert("An error occurred: " + x.status + "nError: " + error);
            }
            jQuery("#loaderDiv").css({
                "display": "none"
            });
        },
        complete: function (xhr) {
            jQuery("#loaderDiv").css({
                "display": "none"
            });
        }
    });
});

$(".numberOnly").numberOnly();
$(".alphaNumericOnly").alphaNumericOnly();
var config = {
    '.chosen-select': {},
    '.chosen-select-deselect': {allow_single_deselect: true},
    '.chosen-select-no-single': {disable_search_threshold: 10},
    '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
    '.chosen-select-width': {width: "95%"}
}
for (var selector in config) {
    $(selector).chosen(config[selector]);
}