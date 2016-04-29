@extends('admin.layouts.master')

@section('sidebar')
    <!-- <a href="" class="active">服务器</a> -->
@endsection

@section('content')
    <div class="title">
        <h2>服务器信息概览</h2>
    </div>
    <table>
        @foreach($infos as $key => $info)
            <tr>
                <td>
                    <span>{{ $info['name'] }}</span>
                    <span class="sep">:</span>
                    <span class="grey">{{ $info['value'] }}</span>
                </td>
            </tr>
        @endforeach
        <!-- <tr>
            <td>
                <span>服务器时间</span>
                <span class="sep">:</span>
                <span class="green" id="result"></span>
            </td>
        </tr> -->
    </table>
    <script type="text/javascript">
        if(typeof(EventSource) !== "undefined" ){
            var source = new EventSource("{{ url('admin/time') }}");
            source.onmessage = function(event){
                document.getElementById("result").innerHTML = event.data;
            };
        }else{
            document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events.";
        }
    </script>
@endsection