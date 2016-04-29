@extends('admin.layouts.master')

@section('content')
    <div class="title">
        <h2>员工</h2> <a href="{{ route('addUser') }}" class="btn-info">新增</a>
    </div>
    <!-- <div class="filter">
        <a href="{{ route('user') }}" class="active">全部<small>({{ count($users) }})</small></a><span class="sep">/</span>
        <a href="#">在职<small>({{ \DB::table('users')->whereStatus(1)->count() }})</small></a><span class="sep">/</span>
        <a href="#">离职<small>({{ \DB::table('users')->whereStatus(0)->count() }})</small></a>
    </div> -->
    <div class="action">
        <!-- 全选：
        <select class="" name="">
            <option value="option">删除</option>
        </select> -->
        <input type="text" value="{{ $key or ''}}" placeholder="姓名" id="key">
        <a class="btn-info" href="javascript:searchUsers($('#key').val())">搜索</a>
    </div>
    <table>
        <tr>
            <!-- <th width="30"><input type="checkbox" name="name" value=""></th> -->
            <th>序号</th>
            <th>姓名</th>
            <th>角色</th>
            <th>小组</th>
            <th>加入时间</th>
            <th>操作</th>
        </tr>
        @foreach($users as $key => $user)
        <tr>
            <!-- <td><input type="checkbox" name="name" value=""></td> -->
            <td>{{ $key + 1 }}</td>
            <td>{{ $user->name }}</td>
            <td>@if($user->role_id == 1) 组长 @elseif($user->role_id == 2) 组员 @else 团长 @endif</td>
            <td>@if($user->group_id) {{ \DB::table('groups')->find($user->group_id)->name }} @else <span class="grey">未分配</span> @endif</td>
            <td>{{ $user->created_at }}</td>
            <td>
                <a href="{{ route('editUser', ['id' => $user->id]) }}" class="grey">编辑</a>
                <a href="#modal" rel="modal" class="grey" id="{{ $user->id }}" data-url="{{ route('delUser', ['id' => $user->id]) }}">删除</a>
                <a href="{{ route('getExperience', ['user_id' => $user->id]) }}" class="grey">战绩</a>
            </td>
        </tr>
        @endforeach
    </table>
    <div class="action">
        {{ $users->render() }}
    </div>
    <!-- 搜索 -->
    <script type="text/javascript">
        function searchUsers(name){
            window.location.href = "{{ route('user') }}?name=" + name;
        }
    </script>
    <!-- 删除 modal start-->
    <div id="modal" style="display: none" class="modal">
        <p id="title"></p>
        <p>
            <a href="" class="hidemodal">取消</a>
            <a id="delUrl" href="" class="btn-info" style="float: right;">确定</a>
        </p>
    </div>
    <script type="text/javascript">
        $(function(){
          $('a[rel*=modal]').leanModal({ top: 150, overlay : 0.45, closeButton: ".modal_close" });
          $('a[rel*=modal]').on("click",  function () {
              var url = $("#" + this.id).data('url');
              $('#title').html('确定删除该用户么？');  
              $('#delUrl').attr('href', url);
          });
        });
    </script>
    <!-- 删除 modal end-->
@endsection
