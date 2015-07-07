require(['./require.config'], function() {
    require(['jquery'], function($) {"use strict";
        console.log($);

        $.ajax({
            method: 'POST',
            url: location.protocol + '://' + location.host + '/item/create',
            data: {
                'name': '電錶'
            },
            success: function(xhr) {
                console.log(xhr);
            }
        });
    });
});