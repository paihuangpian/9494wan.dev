@extends('admin.layouts.master')

@section('sidebar')
    @include('admin.system.sidebar')
@endsection

@section('content')
    <div class="title">
        <h2>员工</h2> <a href="{{ route('addUser') }}" class="btn-info">新增</a>
    </div>
    <div class="filter">
        <a href="#" class="active">全部<small>({{ count($users) }})</small></a><span class="sep">/</span><a href="#">在职<small>({{ \DB::table('users')->whereStatus(1)->count() }})</small></a><span class="sep">/</span><a href="#">离职<small>({{ \DB::table('users')->whereStatus(0)->count() }})</small></a>
    </div>
    <div class="action">
        全选：
        <select class="" name="">
            <option value="option">删除</option>
        </select>
        查找：<input type="text" value="{{ $key or ''}}" placeholder="姓名" onkeyup="searchUsers(this.value)">
    </div>
    <table>
        <tr>
            <th width="30"><input type="checkbox" name="name" value=""></th>
            <th>序号</th>
            <th>姓名</th>
            <th>角色</th>
            <th>小组</th>
            <th>操作</th>
        </tr>
        @foreach($users as $key => $user)
        <tr>
            <td><input type="checkbox" name="name" value=""></td>
            <td>{{ $key + 1 }}</td>
            <td>{{ $user->name }}</td>
            <td>@if($user->role_id == 1) 组长 @elseif($user->role_id == 2) 组员 @else 团长 @endif</td>
            <td>@if($user->group_id) {{ \DB::table('groups')->find($user->group_id)->name }} @else <span class="grey">未分配</span> @endif</td>
            <td><a href="#">编辑</a></td>
        </tr>
        @endforeach
    </table>
    <div class="action">
        {{ $users->render() }}
    </div>
    <!-- 搜索 start -->
    
    <script type="text/javascript">
        function searchUsers(name){
            window.location.href = "{{ route('user') }}?name=" + name;
        }
    </script>
    <!-- 指派 modal end -->
@endsection
