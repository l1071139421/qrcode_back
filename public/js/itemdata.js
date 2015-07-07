require(['./require.config'], function() {
    require(['jquery', 'bootstrap'], function($) {"use strict";

        var _title = '<div class="row"><div class="col-md-2 t-set">序號</div><div class="col-md-2 t-set">類別</div><div class="col-md-2 t-set">Token</div><div class="col-md-2 t-set">財產編號</div><div class="col-md-2 t-set">地址</div><div class="col-md-2 t-set">更改</div></div>';
        var _template = '<div class="row"><div class="col-md-2 t-set">{{num}}</div><div class="col-md-2 t-set item_id_class">{{class}}</div><div class="col-md-2 t-set">{{token}}</div><div class="col-md-2 t-set">{{pn}}</div><div class="col-md-2 t-set">{{address}}</div><div class="col-md-1 t-set" itemid="{{id}}"><button type="button" class="btn btn-default updatebtn">修改</button></div><div class="col-md-1 t-set" itemid="{{id}}"><button type="button" class="btn btn-default deletebtn">刪除</button></div></div>';
        var $c_items = $('.c_item_id');
        var $u_items = $('.u_item_id');
        var baseUrl = location.protocol + '//' + location.host;
        var $table = $('.itemdataTable');

        function getItemOption($items)
        {
            $items.html('');
            $.ajax({
                method: 'get',
                url: baseUrl + '/item/get',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(xhr) {
                    if (!xhr.length) {
                        return ;
                    }

                    for (var i = 0, len = xhr.length; i < len; i++) {
                        var $option = $('<option></option>');
                        $option.html(xhr[i].name);
                        $option.val(xhr[i].id);
                        $items.append($option);
                    }
                },
                error:function () {

                }
            });
        }

        $('.createbtn').on('click', function() {
            var token = $('.c_item_token').val(),
                pn = $('.c_property_num').val(),
                iid = $c_items.val(),
                address = $('.c_address').val();
            $.ajax({
                method: 'post',
                url: baseUrl + '/itemdata/create',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'item_id': iid,
                    'item_token': token,
                    'property_num': pn,
                    'address': address
                },
                success: function(xhr) {
                    $('.c_item_token').val('');
                    $('.c_property_num').val('');
                    $('.c_address').val('');
                    showItemData();
                },
                error:function (xhr) {
                }
            });
        });

        getItemOption($c_items);
        getItemOption($u_items);
        showItemData();
        getItemData();

        function showItemData()
        {
            $table.html('');
            $.ajax({
                method: 'get',
                url: baseUrl + '/itemdata/get',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(xhr) {
                    if (!xhr.length) {
                        $table.html('資料庫中沒有資料');
                        return ;
                    }

                    $table.html(_title);
                    for (var i = 0, len = xhr.length; i < len; i++) {
                        var str = _template;
                        str = str.replace('{{num}}', i+1)
                            .replace('{{class}}', xhr[i].name)
                            .replace('{{token}}', xhr[i].token)
                            .replace('{{pn}}', xhr[i].property_num)
                            .replace('{{address}}', xhr[i].address)
                            .replace('{{id}}', xhr[i].id).replace('{{id}}', xhr[i].id);
                        $table.append(str);
                    }
                },
                error:function () {
                    $table.html('資料發生錯誤');
                }
            });
        }

        function getItemData()
        {
            $.ajax({
                method: 'get',
                url: baseUrl + '/item/get',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(xhr)
                {
                    $table.find('.item_id_class').each(function() {
                        var $id = $(this).html();
                        for (var i = 0, len = xhr.length; i < len; i++) {
                            if (xhr[i].id == $id) {
                                $(this).html(xhr[i].name);
                            }
                        } 
                    });
                }
            });
        }

        $table.on('click', ".deletebtn", function() {
            var id = $(this).parent().attr('itemid');
            $.ajax({
                method: 'post',
                url: baseUrl + '/itemdata/delete',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id': id
                },
                success: function(xhr) {
                    showItemData();
                },
                error:function (xhr) {
                    $table.html('資料庫錯誤');
                }
            });
        });

        $table.on('click', ".updatebtn", function() {
            var id = $(this).parent().attr('itemid');
            var token = $('.u_item_token').val(),
                pn = $('.u_property_num').val(),
                iid = $u_items.val(),
                address = $('.u_address').val();
            $.ajax({
                method: 'post',
                url: baseUrl + '/itemdata/update',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id': id,
                    'item_id': iid,
                    'item_token': token,
                    'property_num': pn,
                    'address': address
                },
                success: function(xhr) {
                    $('.u_item_token').val('');
                    $('.u_property_num').val('');
                    $('.u_address').val('');
                    showItemData();
                },
                error:function (xhr) {
                    $table.html('資料庫錯誤');
                }
            });
        });
    });
});