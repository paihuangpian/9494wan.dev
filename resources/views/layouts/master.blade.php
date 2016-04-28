<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>格木网络</title>
    <link href="/css/normalize.min.css" rel="stylesheet">
    <link href="/css/home.css" rel="stylesheet">
    <link href="/css/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="http://cdn.bootcss.com/jquery/2.2.1/jquery.min.js"></script>
    <script src="/js/jquery.modal.min.js"></script>
    <script src="/js/tempo.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="b"></div>
            <p><img src="/images/sign/{{ \DB::table('levels')->find(\DB::table('user_levels')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first()->level_id)->sign }}" ></p>
            <h2>欢迎亲爱的   <span class="origin">{{ Auth::user()->name }}</span> 同学回家，您当前等级为 <span class="red">{{ \DB::table('levels')->find(\DB::table('user_levels')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first()->level_id)->name }}</span>，感谢您为共同梦想辛劳付出！</h2>
            <p><a href="">一张图告诉你：当一个司令有多可怕。</a></p>
        </div>
        
        <div class="nav @if(Auth::user()->role_id == 1) zuzhang @endif" >
            <div class="b"></div>
            <a href="/" @if(in_array(Route::currentRouteName(), ['/'])) class="active" @endif>主页</a>
            <a href="{{ route('rank') }}" @if(in_array(Route::currentRouteName(), ['rank'])) class="active" @endif>排行</a>
            <a href="{{ route('plan') }}" @if(in_array(Route::currentRouteName(), ['plan'])) class="active" @endif>成长计划</a>
            <a href="{{ route('book') }}" @if(in_array(Route::currentRouteName(), ['book'])) class="active" @endif>绝对发言权</a>
            @if(Auth::user()->role_id == 1)
                <a href="{{ route('groupAdmin') }}" @if(in_array(Route::currentRouteName(), ['groupAdmin', 'addRecord', 'getUser'])) class="active" @endif>组长管理</a>
            @endif
            <a href="{{ url('/logout') }}">退出系统</a>
        </div>
        <!-- 消息 -->
        @if (count($errors) > 0 )
            <div class="errors" style="margin-top: 10px">
                <i class="fa fa-exclamation-circle"></i>
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        <div class="main">
            <div class="b"></div>
            @yield('content')
        </div>

        <div class="silingbu">
            <p>不想当司令的士兵不是一个好士兵！</p>
        </div>
         <div class="footer">
            格木网络科技有限公司 Copyright © 2016 Gemu. All Rights Reserved
        </div>
    </div>
</body>
</html>
