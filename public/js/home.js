require(['./require.config'], function() {
    require(['jquery', 'bootstrap'], function($) {"use strict";


        // $('.CI').on('click', function() {
        //     alert($('meta[name="csrf-token"]').attr('content'));
        //     $.ajax({
        //         method: 'POST',
        //         url: 'item/create',
        //         data: {
        //             '_token': $('meta[name="csrf-token"]').attr('content'),
        //             'name': '電錶'
        //         },
        //         success: function(xhr) {
        //             console.log(xhr);
        //         },
        //         error: function (xhr) {
        //             alert(xhr.responseJSON);
        //         }
        //     });
        // });

        // var $st = $('.starter-template');
        
        // $('.records').on('click', function() {
        //     $.ajax({
        //         method: 'get',
        //         url: 'test/record',
        //         data: {
        //             '_token': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(xhr) {
        //             $st.html(xhr);
        //         }
        //     });
        // });

        // $('.items').on('click', function() {
        //     $.ajax({
        //         method: 'get',
        //         url: 'test/item',
        //         data: {
        //             '_token': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(xhr) {
        //             $st.html(xhr);
        //         }
        //     });
        // });

        // $('.itemdata').on('click', function() {
        //     $.ajax({
        //         method: 'get',
        //         url: 'test/itemdata',
        //         data: {
        //             '_token': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(xhr) {
        //             $st.html(xhr);
        //         }
        //     });
        // });

        // $('.report').on('click', function() {
        //     $.ajax({
        //         method: 'get',
        //         url: 'test/report',
        //         data: {
        //             '_token': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(xhr) {
        //             $st.html(xhr);
        //         }
        //     });
        // });
    });
});