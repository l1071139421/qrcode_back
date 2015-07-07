require(['./require.config'], function() {
    require(['jquery', 'bootstrap'], function($) {
        'use strict';

        var _title = '<div class="row">'+
            '<div class="col-md-2 t-set">日期</div>'+
            '<div class="col-md-2 t-set">類別</div>'+
            '<div class="col-md-1 t-set">製表人</div>'+
            '<div class="col-md-2 t-set">帳單金額</div>'+
            '<div class="col-md-2 t-set">帳單度數</div>'+
            '<div class="col-md-2 t-set">登記度數</div>'+
            '<div class="col-md-1 t-set">修改</div>'+
            '</div>';
        var _template = '<div class="row">' +
            '<div class="col-md-2 t-set">{{date}}</div>' +
            '<div class="col-md-2 t-set item_id_class">{{iname}}</div>' +
            '<div class="col-md-1 t-set">{{uname}}</div>' +
            '<div class="col-md-2 t-set">{{bill}}</div>' +
            '<div class="col-md-2 t-set">{{bill_degree}}</div>' +
            '<div class="col-md-2 t-set">{{degree}}</div>' +
            '<div class="col-md-1 t-set" reportid="{{id}}">' +
            '<button type="button" class="btn btn-default updatebtn">修改</button></div></div>';
        var $c_items = $('.c_item_id');
        var $u_items = $('.u_item_id');
        var baseUrl = location.protocol + '//' + location.host;
        var $table = $('.reportTable');

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

        function showData()
        {
            var tmp = $('.f_date').val(),
                date = new Date(tmp),
                level = tmp.split('-'),
                inputdate = '';
            var datestr = '';

            if (!tmp) {
                date = new Date();
                level = [
                    date.getFullYear(),
                    date.getMonth(),
                    date.getDate()
                ];
            }

            if (level.length >= 1 && level.length <= 3) {
                inputdate = inputdate + date.getFullYear();
            }

            if (level.length >= 2 && level.length <= 3) {
                if ((date.getMonth() + 1) < 10) {
                    datestr = '0' + (date.getMonth() + 1);
                } else {
                    datestr = (date.getMonth() + 1);
                }
                inputdate = inputdate + '-' + datestr;
            }

            if (level.length == 3) {
                if (date.getDate() < 10) {
                    datestr = '0' + date.getDate();
                } else {
                    datestr = date.getDate();
                }
                inputdate = inputdate + '-' + datestr;
            }

            $table.html('');
            $.ajax({
                method: 'get',
                url: baseUrl + '/report/' + inputdate,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(xhr)
                {
                    if (!xhr.length) {
                        $table.html('資料庫中沒有' + inputdate + '的報表');
                        return ;
                    }

                    $table.html(_title);
                    for (var i = 0, len = xhr.length; i < len; i++) {
                        var str = _template;
                        str = str.replace('{{date}}', xhr[i].date)
                            .replace('{{iname}}', xhr[i].iname)
                            .replace('{{uname}}', xhr[i].uname)
                            .replace('{{item_token}}', xhr[i].item_token)
                            .replace('{{bill}}', xhr[i].bill)
                            .replace('{{bill_degree}}', xhr[i].bill_degree)
                            .replace('{{degree}}', xhr[i].degree)
                            .replace('{{id}}', xhr[i].id);
                        $table.append(str);
                    }
                }
            });
        }

        $('.search').click(function() {
            showData();
        });

        $('.createbtn').click(function() {
            var itemid = $c_items.val(),
                bill = $('.c_bill').val(),
                bd = $('.c_bill_degree').val(),
                date = $('.c_date').val();

            $.ajax({
                method: 'post',
                url: baseUrl + '/report/create',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'item_id': itemid,
                    'bill': bill,
                    'bill_degree': bd,
                    'date': date
                },
                success: function(xhr) {
                    $('.c_date').val('');
                    $('.c_bill_degree').val('');
                    $('.c_bill').val('');
                    showData();
                },
                error: function(xhr) {
                    $table.html('資料庫發生錯誤');
                }
            });
        });

        $table.on('click', '.updatebtn', function() {
            var itemid = $u_items.val(),
                bill = $('.u_bill').val(),
                bd = $('.u_bill_degree').val(),
                date = $('.u_date').val();
            $.ajax({
                method: 'post',
                url: baseUrl + '/report/update',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'item_id': itemid,
                    'bill': bill,
                    'bill_degree': bd,
                    'date': date
                },
                success: function(xhr) {
                    $('.u_date').val('');
                    $('.u_bill_degree').val('');
                    $('.u_bill').val('');
                    showData();
                },
                error: function(xhr) {
                    $table.html('資料庫發生錯誤');
                }
            });
        });

        getItemOption($c_items);
        getItemOption($u_items);
        showData();
    });
});