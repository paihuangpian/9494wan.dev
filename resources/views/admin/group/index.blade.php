@extends('admin.layouts.master')

@section('content')
    <div class="title">
        <h2>军团</h2> <a href="{{ route('addGroup') }}" class="btn-info">新增</a>
    </div>
    <table>
        <tr>
            <th>团号</th>
            <th>名称(人数)(组长)</th>
            <th>级别</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        @foreach($groups as $key => $group)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>
            <span class="blue">{{ $group->name }}</span>
            (
                <?php
                     $childGroups = \DB::table('groups')->where('pid', $group->id)->get();
                     $i = 0;
                     foreach($childGroups as $childGroup){
                        $i += \DB::table('users')->where('group_id', $childGroup->id)->count();
                     }
                     echo $i;
                ?>
            人)
            </td>
            <td>军团</td>
            <td>@if($group->status) 已启用 @else <span class="red">未启用</span> @endif</td>
            <td>
                <a href="{{ route('editGroup', ['id' => $group->id]) }}" class="grey">编辑</a>
                <a href="#modal" rel="modal" class="grey" id="{{ $group->id }}" data-url="{{ route('delGroup', ['id' => $group->id]) }}" data-level="{{ $group->level }}">删除</a>
            </td>
        </tr>
            @foreach($group->child as $key_child => $child)
            <tr>
                <td></td>
                <td style="text-indent: 40px">
                    {{ $child->name }} ({{ \DB::table('users')->where('group_id', $child->id)->count() }} 人) 
                    <!-- <a href="#modalZu" rel="modalZu" class="grey" id="{{ $child->id }}" data-url="{{ route('delGroup', ['id' => $child->id]) }}" data-level="{{ $child->level }}">组长(@if(\DB::table('users')->whereRole_idAndGroup_id(1, $child->id)->first()) {{ \DB::table('users')->whereRole_idAndGroup_id(1, $child->id)->first()->name }} @else 暂无 @endif)</a> -->
                    (<span class="origin">@if(\DB::table('users')->whereRole_idAndGroup_id(1, $child->id)->first()) {{ \DB::table('users')->whereRole_idAndGroup_id(1, $child->id)->first()->name }} @else 暂无 @endif</span>)
                </td>
                <td>小组</td>
                <td>@if($child->status) 已启用 @else <span class="red">未启用</span> @endif</td>
                <td>
                    <a href="{{ route('editGroup', ['id' => $child->id]) }}" class="grey">编辑</a>
                    <a href="#modal" rel="modal" class="grey" id="{{ $child->id }}" data-url="{{ route('delGroup', ['id' => $child->id]) }}" data-level="{{ $child->level }}">删除</a>
                </td>
            </tr>
            @endforeach
        @endforeach
    </table>
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
              var level = $("#" + this.id).data('level');
              if(level == 1){
                 $('#title').html('删除该军团后，该军团所有小组跟随删除，并且所有成员恢复无组状态，确定删除该军团么？');
              }else{
                 $('#title').html('删除该小组后，该小组所有成员恢复无组状态，确定删除该小组么？');  
              }
              $('#delUrl').attr('href', url);
          });
        });
    </script>
    <!-- 删除 modal end-->
    <!-- 指派 modal start -->
    <div id="modalZu" style="display: none" class="modal">
        <p><input type="text" onkeyup="searchUsers(this.value)" value=""  id="searchName" placeholder="搜索"></p>
        <div id="users">
          <p data-template>
            @{{ name }} <a href="{{ route('setUser') }}?user_id=@{{ id }}&group_id=@{{ group_id }}&role_id=@{{ role_id }}" class="grey">选定</a>
          </p>
        </div>
        <img id="loading" src="/images/loading.gif">
    </div>
    <script type="text/javascript">
        var users = Tempo.prepare('users').when(TempoEvent.Types.RENDER_STARTING, function (event) {
            $('#loading').show();
        }).when(TempoEvent.Types.RENDER_COMPLETE, function (event) {
            $('#loading').hide();
        });
        $(function(){
          $('a[rel*=modalZu]').leanModal({ top: 150, overlay : 0.45, closeButton: ".modal_close" });
          $('a[rel*=modalZu]').on("click",  function () {
               
               users.starting();
               $.getJSON("{{ route('getUsers') }}", function(data) {
                    users.render(data);
               });
          });
        });
        function searchUsers(name){
            users.starting();
            $.getJSON("{{ route('searchUsers') }}?name=" + name, function(data) {
                users.render(data);
            });
        }
    </script>
    <!-- 指派 modal end -->
@endsection
