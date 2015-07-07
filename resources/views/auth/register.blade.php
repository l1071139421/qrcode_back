<html>
    <head>
        <meta charset='utf8'/>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" type="text/css" href="<?=asset('css/bootstrap/bootstrap.min.css');?>"/>
        <link rel="stylesheet" type="text/css" href="<?=asset('css/bootstrap/bootstrap-theme.min.css');?>"/>
    </head>
    <body>
        <div class="container">
            <!-- resources/views/auth/register.blade.php -->

            <form method="POST" action="/auth/register">
                {!! csrf_field() !!}

                <div class="form-group">
                <label>Name</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Name" value="{{ old('name') }}">
                </div>

                 <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label>Level</label>
                    <select class="form-control" name="compentent">
                      <option value='crew'>crew</option>
                      <option value='leader'>leader</option>
                      <option value='minister'>minister</option>
                      <option value='commissioner'>commissioner</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password" placeholder="Password">
                </div>
                <div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
            </form>
        </div>
    </body>
</html>