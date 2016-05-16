(function ($) {
    //allow number only
    $.fn.numberOnly = function () {
        this.keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    };
    //allow alphanumeric
    $.fn.alphaNumericOnly = function () {
        this.keypress(function (e) {
            if (!(e.which > 47 && e.which < 58) && // numeric (0-9)
                    !(e.which > 64 && e.which < 91) && // upper alpha (A-Z)
                    !(e.which > 96 && e.which < 123)) { // lower alpha (a-z)
                return false;
            }
        });
    };

}(jQuery));