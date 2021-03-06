/**
 * Created by bao on 26/05/2017.
 */
define([
    'jquery',
    'Magento_Customer/js/customer-data'
], function ($, customerData) {
    "use strict";

    window.reloadSection = function() {
        customerData.invalidate(['customer', 'cart', 'last-ordered-items', 'wishlist', 'affiliate']);
        customerData.reload(['customer', 'product-purchased-customer', 'last-ordered-items', 'wishlist', 'affiliate'], true);
        location.reload();
    };

    return {
        display: function(url, title, w, h){
            var left = screen.width/2 - w / 2;
            var top = screen.height/2 - h / 2;
            var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

            // Puts focus on the newWindow
            if (window.focus) {
                newWindow.focus();
            }
        },
    };
});
