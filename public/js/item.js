require(['./require.config'], function() {
    require(['jquery', 'bootstrap'], function($) {"use strict";

        var _title = '<div class="row"><div class="col-md-4 t-set">序號</div><div class="col-md-4 t-set">名稱</div><div class="col-md-4 t-set">更改</div></div>';
        var _template = '<div class="row"><div class="col-md-4 t-set">{{num}}</div><div class="col-md-4 t-set">{{name}}</div><div class="col-md-3 t-set" itemid="{{id}}"><form class="form-inline"><input type="text" class="form-control updateinput" name="name" id="exampleInputEmail3" placeholder="Name"><button type="button" class="btn btn-default updatebtn">修改</button></form></div><div class="col-md-1 t-set" itemid="{{id}}"><button type="button" class="btn btn-default deletebtn">刪除</button></div></div>';
        var $items = $('.itemTable');
        var baseUrl = location.protocol + '//' + location.host;

        function getdata() {
            $.ajax({
                method: 'get',
                url: baseUrl + '/item/get',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(xhr) {
                    // $items.html(xhr);
                    // console.log(xhr);
                    $items.html('');
                    if (!xhr.length) {
                        $items.html('資料庫內沒有資料');
                        return ;
                    }

                    $items.html(_title);
                    for (var i = 0, len = xhr.length; i < len; i++) {
                        var str = _template;

                        str = str.replace('{{num}}', i+1).replace('{{name}}', xhr[i].name).replace('{{id}}', xhr[i].id).replace('{{id}}', xhr[i].id);
                        $items.append(str);
                    }
                },
                error: function(xhr) {
                    $items.html('資料庫發生錯誤');
                }
            });
        }

        getdata();

        $items.on("click", ".deletebtn", function() {
            var $id = $(this).parent().attr('itemid');

            $.ajax({
                method: 'post',
                url: baseUrl + '/item/delete',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id': $id
                },
                success: function(xhr) {
                    getdata();
                },
                error: function(xhr) {
                    $items.html('資料庫發生錯誤');
                }
            });
        });

        $items.on("click", ".updatebtn", function() {
            var $id = $(this).parent().parent().attr('itemid'),
                $name = $(this).prev().val();

            if (!$name) {
                return ;
            }

            $.ajax({
                method: 'post',
                url: baseUrl + '/item/update',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id': $id,
                    'name': $name
                },
                success: function(xhr) {
                    getdata();
                },
                error: function(xhr) {
                    $items.html('資料庫發生錯誤');
                }
            });
        });

        $('.createbtn').click(function() {
            var $name = $('.createInput').val();

            if (!$name) {
                return ;
            }

            $.ajax({
                method: 'post',
                url: baseUrl + '/item/create',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'name': $name
                },
                success: function(xhr) {
                    getdata();
                },
                error: function(xhr) {
                    $items.html('資料庫發生錯誤');
                }
            });
        });
    });
});