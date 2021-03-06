<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>格木网络</title>
        <link href="/css/normalize.min.css" rel="stylesheet">
        <link href="/css/admin.css" rel="stylesheet">
        <link href="/css/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet">
        <script src="http://cdn.bootcss.com/jquery/2.2.1/jquery.min.js"></script>
        <script src="/js/jquery.modal.min.js"></script>
        <script src="/js/tempo.min.js"></script>
    </head>
    <body>
        <!-- 主导航 -->
        <div class="nav">
            <a href="javascript:;" class="brand"><b>格木网络</b></a>
            <ul>
                <!-- <li><a href="{{ route('admin') }}" @if(Route::currentRouteName() == 'admin') class="active" @endif>首页</a></li> -->
                <li><a href="{{ route('dashboard') }}" @if(Route::currentRouteName() == 'dashboard') class="active" @endif>仪表盘</a></li>
                <li><a href="{{ route('level') }}" @if(Route::currentRouteName() == 'level') class="active" @endif>等级</a></li>
                <li><a href="{{ route('group') }}" @if(in_array(Route::currentRouteName(), ['group', 'addGroup', 'editGroup'])) class="active" @endif>军团</a></li>
                <li><a href="{{ route('user') }}" @if(Route::currentRouteName() == 'user') class="active" @endif>员工</a></li>
                <li><a href="{{ route('bookAdmin') }}" @if(in_array(Route::currentRouteName(), ['bookAdmin'])) class="active" @endif>留言板</a></li>
                <!-- <li><a href="">文章</a></li> -->
            </ul>

            <div class="admin">
                <a href="" class="admin-name">{{ Auth::guard('admin')->user()->name }} <i class="fa fa-chevron-down"></i></a>
                <div class="admin-drop">
                    <!-- <a href="{{ url('admin/password/reset') }}">更改密码</a> -->
                    <a href="{{ url('admin/logout') }}">退出</a>
                </div>
            </div>
        </div>

        <!-- 侧边导航 -->
        <div class="sidebar">
            @yield('sidebar')
        </div>

        <!-- 消息 -->
        @if (count($errors) > 0 )
            <div class="errors">
                <i class="fa fa-exclamation-circle"></i>
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <!-- 内容 -->
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
