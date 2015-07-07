<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf8'/>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" type="text/css" href="<?=asset('css/bootstrap/bootstrap.min.css');?>"/>
        <link rel="stylesheet" type="text/css" href="<?=asset('css/bootstrap/bootstrap-theme.min.css');?>"/>
        <style>
            body {
                padding-top: 50px;
            }
            .starter-template {
                padding: 40px 15px;
                text-align: center;
            }
            .float-right {
                float: right;
            }

            .t-set {    
                border: #000000 solid 1px;
                height: 45px;
                text-align: center;
                line-height: 45px;
            }

            .right {
                float: right;
            }
        </style>
    </head>
    <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href=<?=asset('/home');?>>Test Project</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href=<?=asset('/test/record');?> class="records">Record</a></li>
                    <li><a href=<?=asset('/test/item');?> class="items">Item</a></li>
                    <li><a href=<?=asset('/test/itemdata');?> class="itemdata">ItemData</a></li>
                    <?php if(Auth::user()->compentent != 'crew') {
                         echo '<li><a href='.asset('/test/report').' class="report">Report</a></li>';
                        }
                    ?>
                </ul>
                <ul class="float-right nav navbar-nav"><li><a href=<?=asset('/auth/logout');?>>logout</a></li></ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
<div class="container">

    <!-- resources/views/auth/login.blade.php -->
    <div>
        <h3>Create Report:</h3>
        <form class="form-inline">
            {!! csrf_field() !!}

            item
            <select class="form-control c_item_id">
            </select>
            bill
            <input type="text" class="form-control c_bill" id="exampleInputEmail3" placeholder="Bill">
            degree on bill
            <input type="text" class="form-control c_bill_degree" id="exampleInputEmail3" placeholder="Degree">
            date
            <input type="datetime" class="form-control c_date" id="exampleInputEmail3" placeholder="date">

            <button type="button" class="btn btn-default createbtn">submit</button>
        </form>
    </div>

    <div>
        <h3>Update Report Column:</h3>
        <form class="form-inline">
            {!! csrf_field() !!}

            item
            <select class="form-control u_item_id">
            </select>
            bill
            <input type="text" class="form-control u_bill" id="exampleInputEmail3" placeholder="Bill">
            degree on bill
            <input type="text" class="form-control u_bill_degree" id="exampleInputEmail3" placeholder="Degree">
            date
            <input type="datetime" class="form-control u_date" id="exampleInputEmail3" placeholder="date">
        </form>
    </div>
    <br>
    <br>
    <div class="col-md-12" style="hight:45px;">
    <form class="form-inline right">
    <input type="datetime" class="form-control f_date" id="exampleInputEmail3" placeholder="Date">
    <button type="button" class="btn btn-default search">搜尋</button>
    </form></div><br/><br/><br/>
    <div class="reportTable"></div>
</div>
</body>
<script src=<?=asset('js/lib/require.js');?> data-main=<?=asset('js/report.js');?>></script>
</html>
