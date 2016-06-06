@extends('admin.layouts.master')

@section('content')
    <div class="title">
        <h2>员工({{ $user->name }})</h2> <a href="{{ route('user') }}" class="btn-info">员工</a>
    </div>
    <p>
        <span class="origin">入伍：</span>{{ date('Y-m-d', strtotime($user->created_at)) }}<span class="sep">/</span>
        <span class="origin">等级：</span>@if($user->level_id){{ \DB::table('levels')->find($user->level_id)->name }}@endif<span class="sep">/</span>
        <span class="origin">小组：</span>@if($user->group_id) {{ \DB::table('groups')->find($user->group_id)->name}} @else 未分配 @endif<span class="sep">/</span>
        <span class="origin">积分：</span><a href="">{{ $user->scores }}</a><span class="sep">/</span>
        <span class="origin">排行：</span>{{ $rank }}
        <span class="sep">/</span>
        <span class="origin">经验值：</span>{{ $user->experience }}<span class="sep">/</span>
        <span class="origin">升级还需：</span>{{ $need_experience }}
    </p>
    <p>战绩概览</p>
    <p>
        <span class="origin">今日战绩：</span>{{ $today }} <span class="sep">/</span>
        <span class="origin">昨日战绩：</span>{{ $yesterday }} <span class="sep">/</span>
        <span class="origin">当月战绩: </span>{{ $current_month[0]->total }} <span class="sep">/</span>
        <span class="origin">上月战绩：</span>{{ $last_month[0]->total }} <span class="sep">/</span>
        <span class="origin">战绩累计：</span>{{ $total }}
    </p>
    <p>战功({{ $records->count() }})</p>
    <p>
        <table>
            <tr><th>战绩</th><th>时间</th><th>删除</th></tr>
            @foreach($records as $record)
                <tr>
                    <td>{{ $record->recharge }}</td>
                    <td>{{ date('Y-m-d', strtotime($record->created_at)) }}</td>
                    <td><a href="#modal" rel="modal" class="grey" id="{{ $record->id }}" data-url="{{ route('delExperience', ['id' => $record->id, 'recharge' => $record->recharge, 'user_id' => $user->id]) }}">删除</a></td>
                </tr>
            @endforeach
        </table>
        <div class="action">
        {{ $records->render() }}
        </div>
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
                  $('#title').html('确定删除该条记录么？');  
                  $('#delUrl').attr('href', url);
              });
            });
        </script>
        <!-- 删除 modal end-->
    </p>
@endsection
