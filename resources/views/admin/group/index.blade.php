@extends('admin.layouts.master')

@section('content')
    <div class="title">
        <h2>军团</h2> <a href="{{ route('addGroup') }}" class="btn-info">新增</a> <!-- <a href="#" class="btn-info">导出Excel</a> -->
    </div>
    <!-- <div class="filter">
        <a href="#" class="active">全部<small>({{ count($groups) }})</small></a><span class="sep">/</span><a href="#">已启用<small>(5)</small></a><span class="sep">/</span><a href="#">未启用<small>(0)</small></a>
    </div> -->
    <!-- <div class="action">
        全选：
        <select class="" name="">
            <option value="option">删除</option>
        </select>
    </div> -->
    <table>
        <tr>
            <th>团号</th>
            <th>名称(人数)</th>
            <th>级别</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        @foreach($groups as $key => $group)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td><span class="blue">{{ $group->name }}</span> <a href="" class="grey">100</a></td>
            <td>军团</td>
            <td>@if($group->status) 已启用 @else <span class="red">未启用</span> @endif</td>
            <td>
                <a href="#" class="grey">编辑</a>
                <a href="#modal" rel="modal" class="grey" id="{{ $group->id }}" data-url="{{ route('delGroup', ['id' => $group->id]) }}" data-level="{{ $group->level }}">删除</a>
            </td>
        </tr>
            @foreach($group->child as $key_child => $child)
            <tr>
                <td></td>
                <td style="text-indent: 40px">
                    {{ $child->name }} 
                    <a href="" class="grey">100</a>
                    <a href="" class="grey">组长(未指派)</a>
                </td>
                <td>小组</td>
                <td>@if($child->status) 已启用 @else <span class="red">未启用</span> @endif</td>
                <td>
                    <a href="#" class="grey">编辑</a>
                    <a href="#modal" rel="modal" class="grey" id="{{ $child->id }}" data-url="{{ route('delGroup', ['id' => $child->id]) }}" data-level="{{ $child->level }}">删除</a>
                </td>
            </tr>
            @endforeach
        @endforeach
    </table>
    <!-- 删除 modal start-->
    <div id="modal" style="display: none">
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
@endsection
