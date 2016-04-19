<!DOCTYPE html>
<html >
<head>
    <title>格木网络</title>
    <link href="http://cdn.bootcss.com/normalize/3.0.3/normalize.min.css" rel="stylesheet">
    <link href="/css/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/login.css" rel="stylesheet">
    <style type="text/css">
    	.i1 input:focus{
			border: solid 1px #d6d6d6;
			border-bottom: none;
		}
		.i2 input:focus{
			border: solid 1px #d6d6d6;
			border-top: solid 1px #e7e7e7;
		}
    </style>
</head>
<body style="background:url(/images/0505.jpg) no-repeat;background-size: cover">
    <div class="form">
        <!-- <div class="form-b"></div> -->
        <h1 style="color: #2780e3;text-align: left;">格木网络</h1>
        <form method="POST" action="{{ url('/admin/login') }}">
        {!! csrf_field() !!}
            <div style="text-align: left;">
                @if (count($errors) > 0 )
                    <div class="errors">
                        @foreach ($errors->all() as $error)
                            <p><i class="fa fa-exclamation-circle"></i> {{ $error }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="i1{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="text" name="email" class="form-control" value="{{ old('email') }}" placeholder="邮箱">
            </div>
            <div class="i2{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" name="password" placeholder="密码">
            </div>  
            <div class="item">
                <button type="submit">登录</button>
            </div>
            <div class="item">
                <!-- <a class="btn btn-link" href="{{ url('/password/reset') }}" style="float: right;color: #333">忘记密码？</a> -->
                <!-- <span  style="float: left"><input type="checkbox" name="remember"> 记住</span> -->
            </div>
        </form>
    </div>
</body>
</html>


