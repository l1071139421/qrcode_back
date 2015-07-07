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
    <h1>Item</h1>
    <div>
        <form class="form-inline">
            {!! csrf_field() !!}
          <div class="form-group">
            <label>Create Item</label>
            <input type="text" class="form-control createInput" name="name" id="exampleInputEmail3" placeholder="Name">
          </div>
          <button type="submit" class="btn btn-default createbtn">submit</button>
        </form>
    </div>
    <br>
    <div class="itemTable">
        
    </div>
</div>
</body>
<script src=<?=asset('js/lib/require.js');?> data-main=<?=asset('js/item.js');?>></script>
</html>