@extends('admin.layouts.master')

@section('content')
    <div class="title">
        <h2>等级</h2> <a href="{{ route('addLevel') }}" class="btn-info">新增</a>
    </div>
    <div class="filter">
        <a href="#" class="active">全部<small>({{ count($levels) }})</small></a>
    </div>
    <table>
        <tr>
            <th>序号</th>
            <th>等级名称</th>
            <th>等级标志</th>
            <th>等级经验</th>
            <th>等级最高经验</th>
            <th>等级衰减值</th>
            <th>等级工资</th>
            <th>消费奖金百分比</th>
            <th>带薪休假天数</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        @foreach($levels as $key => $level)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $level->name }}</td>
            <td><img src="/images/sign/{{ $level->sign }}"></td>
            <td>{{ $level->experience }}</td>
            <td>{{ $level->experience_max }}</td>
            <td>{{ $level->attenuation }}</td>
            <td>{{ $level->wages }}</td>
            <td>{{ $level->commission }}</td>
            <td>{{ $level->vacation }}</td>
            <td>@if($level->status) 已启用 @else <span class="red">未启用</span> @endif</td>
            <td>
                <a href="{{ route('editLevel', ['id' => $level->id]) }}" class="grey">编辑</a>
                <a href="#modal" rel="modal" class="grey" id="{{ $level->id }}" data-url="{{ route('delLevel', ['id' => $level->id]) }}">删除</a>
            </td>
        </tr>
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
              $('#title').html('确定删除该等级么？');
              $('#delUrl').attr('href', url);
          });
        });
    </script>
    <!-- 删除 modal end-->
@endsection
