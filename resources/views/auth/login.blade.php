<!DOCTYPE html>
<html >
<head>
    <title>格木网络推广部</title>
    <link href="http://cdn.bootcss.com/normalize/3.0.3/normalize.min.css" rel="stylesheet">
    <link href="/css/login.css" rel="stylesheet">
</head>
<body>
    
    <div class="form">
        <div class="form-b"></div>
        <h1>格木网络推广部</h1>
        <div class="news">莎士比亚：世上并没有用来鼓励工作努力的赏赐，所有的赏赐都只是被用来奖励工作成果的。</div>
        <form method="POST" action="{{ url('/login') }}">
        {!! csrf_field() !!}
            <div class="{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="邮件">
            </div>
            <div class="{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" name="password" placeholder="密码">
            </div>
            <div class="item">
                <a class="btn btn-link" href="{{ url('/password/reset') }}" style="float: right;">忘记密码？</a>
                <span  style="float: left"><input type="checkbox" name="remember"> 记住</span>
            </div>
            <div class="item">
                <button type="submit">登录</button>
            </div>
        </form>
    </div>
</body>
</html>


