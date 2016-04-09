<a href="{{ route('menus') }}">站点</a>
<a href="{{ route('menus') }}">用户</a>
<a href="{{ route('menus') }}" @if(Route::currentRouteName() == 'menus') class="active" @endif>菜单</a>
<a href="{{ route('menus') }}">数据</a>