(function ($) { /* Sets up jquery with the $ function */
    'use strict';

    /* Data is passed from php as 'modern_wp_plugin_server_data' js object */

    $(document).ready(function () {

        const server_data = modern_wp_plugin_server_data;

        if (server_data.disable_wp_title) {
            $('h1.entry-title').hide();
        }

        function getDate(element) {
            let date;
            try {
                date = $.datepicker.parseDate(dateFormat, element.value);
            } catch (error) {
                date = null;
            }

            return date;
        }

        const dateFormat = "mm/dd/yy";

        const checkinOptions = {
            minDate: 0
        };

        const fromDate = $("#checkin").datepicker(checkinOptions)
            .on("change", function () {
                toDate.datepicker("option", "minDate", getDate(this));
            });

        const checkoutOptions = {
            minDate: 1
        };

        const toDate = $("#checkout").datepicker(checkoutOptions)
            .on("change", function () {
                fromDate.datepicker("option", "maxDate", getDate(this));
            });
    });
})(jQuery);