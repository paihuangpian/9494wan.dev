<a href="{{ route('menus') }}">工会</a>
<a href="{{ route('menus') }}">充值</a>
<a href="{{ route('menus') }}" @if(Route::currentRouteName() == 'menus') class="active" @endif>收入</a>
<a href="{{ route('menus') }}">数据</a>