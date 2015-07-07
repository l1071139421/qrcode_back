require(['./require.config'], function() {
    require(['jquery', 'bootstrap'], function($) {"use strict";

        var _title = '<div class="row">'+
            '<div class="col-md-2 t-set">日期</div>'+
            '<div class="col-md-2 t-set">抄表人</div>'+
            '<div class="col-md-2 t-set">類別</div>'+
            '<div class="col-md-2 t-set">Token</div>'+
            '<div class="col-md-2 t-set">度數</div>'+
            '<div class="col-md-2 t-set">更改</div>'+
            '</div>';
        var _template = '<div class="row">' +
            '<div class="col-md-2 t-set">{{date}}</div>' +
            '<div class="col-md-2 t-set item_id_class">{{uname}}</div>' +
            '<div class="col-md-2 t-set item_id_class">{{iname}}</div>' +
            '<div class="col-md-2 t-set">{{item_token}}</div>' +
            '<div class="col-md-2 t-set">{{degree}}</div>' +
            '<div class="col-md-1 t-set" recordid="{{id}}">' +
            '<button type="button" class="btn btn-default updatebtn">修改</button></div>' +
            '<div class="col-md-1 t-set" recordid="{{id}}">' +
            '<button type="button" class="btn btn-default deletebtn">刪除</button></div></div>';
        var $c_items = $('.c_item_token');
        var $u_items = $('.u_item_id');
        var baseUrl = location.protocol + '//' + location.host;
        var $table = $('.recordTable');

        function getItemOption($items)
        {
            $items.html('');
            $.ajax({
                method: 'get',
                url: baseUrl + '/itemdata/get',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(xhr) {
                    if (!xhr.length) {
                        return ;
                    }

                    for (var i = 0, len = xhr.length; i < len; i++) {
                        var $option = $('<option></option>');
                        $option.html(xhr[i].token);
                        $option.val(xhr[i].item_id + '-' + xhr[i].token);
                        $items.append($option);
                    }
                },
                error:function (xhr) {
                    console.log(xhr);
                }
            });
        }

        function showData()
        {
            var uri = '';
            if ($table.hasClass('crew')) {
                uri = '/record/user';
            } else {
                uri = '/record/get';
            }

            $table.html('');
            $.ajax({
                method: 'get',
                url: baseUrl + uri,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(xhr) {
                    if (!xhr.length) {
                        $table.html('資料庫中沒有資料');
                        return ;
                    }

                    $table.html(_title);
                    for (var i = 0, len = xhr.length; i < len; i++) {
                        var str = _template;
                        str = str.replace('{{date}}', xhr[i].date.substr(0, 10))
                            .replace('{{iname}}', xhr[i].iname)
                            .replace('{{uname}}', xhr[i].uname)
                            .replace('{{item_token}}', xhr[i].item_token)
                            .replace('{{degree}}', xhr[i].degree)
                            .replace('{{id}}', xhr[i].id).replace('{{id}}', xhr[i].id);
                        $table.append(str);
                    }
                },
                error: function(xhr) {
                    $table.html('資料庫發生錯誤');
                }
            });
        }

        $('.createbtn').click(function() {
            var degree = $('.c_degree').val(),
                tmp = $c_items.val(),
                arr = tmp.split('-'),
                item_id = arr[0],
                token = arr[1];

            $.ajax({
                method: 'post',
                url: baseUrl + '/record/create',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'item_token': token,
                    'degree': degree,
                    'item_id': item_id
                },
                success: function(xhr) {
                    $('.c_degree').val('');
                    showData();
                },
                error: function(xhr) {
                    $table.html('資料庫發生錯誤');
                }
            });
        });

        $table.on('click', '.deletebtn', function() {
            var id = $(this).parent().attr('recordid');
            $.ajax({
                method: 'post',
                url: baseUrl + '/record/delete',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id': id
                },
                success: function(xhr) {
                    showData();
                },
                error:function (xhr) {
                    $table.html('資料庫錯誤');
                }
            });
        });

        $table.on('click', '.updatebtn', function() {
            var id = $(this).parent().attr('recordid'),
                degree = $('.u_degree').val();
            $.ajax({
                method: 'post',
                url: baseUrl + '/record/update',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id': id,
                    'degree': degree
                },
                success: function(xhr) {
                    $('.u_degree').val()
                    showData();
                },
                error:function (xhr) {
                    $table.html('資料庫錯誤');
                }
            });
        });

        getItemOption($c_items);
        showData();
    });
});