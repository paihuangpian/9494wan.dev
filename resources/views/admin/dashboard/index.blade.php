@extends('admin.layouts.master')

@section('sidebar')

@endsection

@section('content')
    <div class="title">
        <h2>概览</h2>
    </div>
    <table>
    	<tr class="origin">
    		<td width="200">员工</td>
    		<td>
	    		总数：{{ count(\DB::table('users')->get()) }} <span class="sep">/</span>
	    		在职：{{ count(\DB::table('users')->where('status', 1)->get()) }} <span class="sep">/</span>
	    		团长：{{ count(\DB::table('users')->where('role_id', 0)->get()) }} <span class="sep">/</span>
	    		组长：{{ count(\DB::table('users')->where('role_id', 1)->get()) }}<span class="sep">/</span>
	    		组员：{{ count(\DB::table('users')->where('role_id', 2)->get()) }}
    		</td>
    	</tr>
    	<tr class="blue">
    		<td width="200">军团</td>
    		<td>
	    		军团：{{ count(\DB::table('groups')->where('level', 1)->get()) }} <span class="sep">/</span>
	    		小组：{{ count(\DB::table('groups')->where('level', 2)->get()) }}
    		</td>
    	</tr>
    	<tr class="red">
    		<td width="200">战绩</td>
    		<td>
	    		今日：{{ \DB::table('records')->whereCreated_at(date('Y-m-d'))->sum('recharge') }} <span class="sep">/</span>
	    		昨日：{{ \DB::table('records')->whereCreated_at(date('Y-m-d', (time() - 3600 * 24)))->sum('recharge') }} <span class="sep">/</span>
	    		本月：{{ $current_month[0]->total }} <span class="sep">/</span>
	    		上月：@if($last_month[0]->total) {{ $last_month[0]->total }} @else 0 @endif<span class="sep">/</span>
	    		总战绩：{{ \DB::table('records')->sum('recharge') }}
    		</td>
    	</tr>
    	<tr>
    		<td width="200">排行</td>
    		<td style="padding: 10px;">
	    		<table style="width: 50%;float: left;">
	    			<caption style="height: 49px;line-height: 50px">个人</caption>
	    			<tr><th>榜</th><th>军衔</th><th>英雄</th><th>总战绩</th></tr>
			        @foreach($persons as $key => $person)
				        <tr>
				            <td>{{ $key + 1 }}</td>
				            <td>
                                @if($person->level_id)
                                    <!-- <img src="/images/sign/{{ \DB::table('levels')->find($person->level_id)->sign }}"> -->
                                    {{ \DB::table('levels')->find($person->level_id)->name }}
                                @endif
                            </td>
				            <td>{{ $person->name }}</td>
				            <td>{{ $person->experience }}</td>
				        </tr>
			        @endforeach
	    		</table>
	    		<table style="width: 49%;float: right;">
	    			<caption style="height: 50px;line-height: 50px">军团</caption>
	    			<tr><th>排行</th><th>军团</th><th>总战绩</th></tr>
			        @foreach($groups as $key => $group)
				        <tr>
				        	<td>{{ $key + 1 }}</td>
				            <td>@if($group->group_id) {{ \DB::table('groups')->find($group->group_id)->name }} @else 未知 @endif</td>
				            <td>{{ $group->total }}</td>
				        </tr>
			        @endforeach
	    		</table>
    		</td>
    	</tr>
    	<tr>
    		<td width="200">战绩</td>
    		<td style="padding: 10px;">
    			<table>
    				<tr><th>员工</th><th>战绩</th><th>时间</th></tr>
    				@foreach($records as $record)
    					<tr>
    						<td>{{ \DB::table('users')->find($record->user_id)->name }}</td>
    						<td>{{ $record->recharge }}</td>
    						<td>{{ $record->created_at }}</td>
    					</tr>
    				@endforeach
    			</table>
    		</td>
    	</tr>
    </table>
@endsection