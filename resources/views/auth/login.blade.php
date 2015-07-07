<html>
    <head>
        <meta charset='utf8'/>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" type="text/css" href="<?=asset('css/bootstrap/bootstrap.min.css');?>"/>
        <link rel="stylesheet" type="text/css" href="<?=asset('css/bootstrap/bootstrap-theme.min.css');?>"/>
    </head>
    <body>
    <!-- resources/views/auth/login.blade.php -->
        <div class="container">
        <form method="POST" action="/auth/login">
            {!! csrf_field() !!}

            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember"> Remember Me
                </label>
            </div>

            <div>
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </form>
        </div>
    </body>
    <script src=<?=asset('js/lib/require.js');?> data-main=<?=asset('js/login.js');?>></script>
</html>