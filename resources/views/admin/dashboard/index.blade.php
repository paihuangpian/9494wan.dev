@extends('admin.layouts.master')

@section('sidebar')

@endsection

@section('content')
    <div class="title">
        <h2>概览</h2>
    </div>
    <table class="dash">
    	<tr>
    		<td width="200">员工</td>
    		<td>
	    		总数：{{ count(\DB::table('users')->get()) }} <span class="sep">/</span>
	    		在职：{{ count(\DB::table('users')->where('status', 1)->get()) }} <span class="sep">/</span>
	    		团长：{{ count(\DB::table('users')->where('role_id', 0)->get()) }} <span class="sep">/</span>
	    		组长：{{ count(\DB::table('users')->where('role_id', 1)->get()) }}<span class="sep">/</span>
	    		组员：{{ count(\DB::table('users')->where('role_id', 2)->get()) }}
    		</td>
    	</tr>
    	<tr>
    		<td width="200">军团</td>
    		<td>
	    		军团：{{ count(\DB::table('groups')->where('level', 1)->get()) }} <span class="sep">/</span>
	    		小组：{{ count(\DB::table('groups')->where('level', 2)->get()) }}
    		</td>
    	</tr>
    	<tr>
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
                <h2 class="green">昨日</h2>
                <div style="width: 49%;float: left;">
                    <div style="height: 50px;line-height: 50px;text-align: left">英雄榜</div>
                    <table>
                        <tr><th>榜</th><th>军徽</th><th>英雄</th><th>总战功</th></tr>
                        @foreach($yesterday_persons as $key => $yesterday_person)
                        <tr>
                            <td>@if(($key + 1) == 1) <span style="color:#eead0e">冠军</span> @elseif(($key + 1) == 2) <span style="color:#cdc1c5">亚军</span> @elseif(($key + 1) == 3) <span style="color:#cd950c">季军</span> @else  {{ $key + 1 }}  @endif</td>
                            <td>
                                @if(\DB::table('users')->find($yesterday_person->user_id)->level_id)
                                    <img src="/images/sign/{{ \DB::table('levels')->find(\DB::table('users')->find($yesterday_person->user_id)->level_id)->sign }}" width="30">   
                                @endif
                            </td>
                            <td>{{ \DB::table('users')->find($yesterday_person->user_id)->name }}</td>
                            <td>{{ $yesterday_person->total }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div style="width: 49%;float: right;">
                    <div style="height: 50px;line-height: 50px;text-align: left;">军团榜</div>
                    <table>
                        <tr><th>榜</th><th>军团</th><th>总战功</th></tr>
                        @foreach($yesterday_groups as $key => $yesterday_group)
                        <tr>
                            <td>@if(($key + 1) == 1) <span style="color:#eead0e">冠军</span> @elseif(($key + 1) == 2) <span style="color:#cdc1c5">亚军</span> @elseif(($key + 1) == 3) <span style="color:#cd950c">季军</span> @else  {{ $key + 1 }}  @endif</td>
                            <td>@if($yesterday_group->group_id) {{ \DB::table('groups')->find($yesterday_group->group_id)->name }} @else 未知 @endif</td>
                            <td>{{ $yesterday_group->total }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div style="clear:both;height: 10px"></div>
                <h2 class="green">上月</h2>
                <div style="width: 49%;float: left;">
                    <div style="height: 50px;line-height: 50px;text-align: left">英雄榜</div>
                    <table>
                        <tr><th>榜</th><th>军徽</th><th>英雄</th><th>总战功</th></tr>
                        @foreach($last_month_persons as $key => $last_month_person)
                        <tr>
                            <td>@if(($key + 1) == 1) <span style="color:#eead0e">冠军</span> @elseif(($key + 1) == 2) <span style="color:#cdc1c5">亚军</span> @elseif(($key + 1) == 3) <span style="color:#cd950c">季军</span> @else  {{ $key + 1 }}  @endif</td>
                            <td>
                            @if(\DB::table('users')->find($last_month_person->user_id)->level_id)
                                <img src="/images/sign/{{ \DB::table('levels')->find(\DB::table('users')->find($last_month_person->user_id)->level_id)->sign }}"  width="30"
                            >@endif
                            </td>
                            <td>{{ \DB::table('users')->find($last_month_person->user_id)->name }}</td>
                            <td>{{ $last_month_person->total }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div style="width: 49%;float: right;">
                    <div style="height: 50px;line-height: 50px;text-align: left;">军团榜</div>
                    <table>
                        <tr><th>榜</th><th>军团</th><th>总战功</th></tr>
                        @foreach($last_month_groups as $key => $last_month_group)
                        <tr>
                            <td>@if(($key + 1) == 1) <span style="color:#eead0e">冠军</span> @elseif(($key + 1) == 2) <span style="color:#cdc1c5">亚军</span> @elseif(($key + 1) == 3) <span style="color:#cd950c">季军</span> @else  {{ $key + 1 }}  @endif</td>
                            <td>@if($last_month_group->group_id) {{ \DB::table('groups')->find($last_month_group->group_id)->name }} @else 未知 @endif</td>
                            <td>{{ $last_month_group->total }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div style="clear:both;height: 10px"></div>
                <h2 class="green">总榜</h2>
                <!-- <p>
                    <span class="origin">今日：</span>{{ \DB::table('records')->whereCreated_at(date('Y-m-d'))->sum('recharge') }}<span class="sep"></span>
                    <span class="origin">昨日：</span>{{ \DB::table('records')->whereCreated_at(date('Y-m-d', (time() - 3600 * 24)))->sum('recharge') }} <span class="sep"></span>
                    <span class="origin">本月：</span>{{ $current_month[0]->total or '暂无数据' }}<span class="sep"></span>
                    <span class="origin">上月：</span>{{ $last_month[0]->total or '暂无数据' }}<span class="sep"></span>
                </p> -->
                <div style="width: 49%;float: left;">
                    <div style="height: 50px;line-height: 50px;text-align: left">英雄榜</div>
                    <table>
                        <tr><th>榜</th><th>军徽</th><th>英雄</th><th>总战功</th></tr>
                        @foreach($persons as $key => $person)
                        <tr>
                            <td>@if(($key + 1) == 1) <span style="color:#eead0e">冠军</span> @elseif(($key + 1) == 2) <span style="color:#cdc1c5">亚军</span> @elseif(($key + 1) == 3) <span style="color:#cd950c">季军</span> @else  {{ $key + 1 }}  @endif</td>
                            <td>@if($person->level_id)<img src="/images/sign/{{ \DB::table('levels')->find($person->level_id)->sign }}" width="30">@endif</td>
                            <td>{{ $person->name }} </td>
                            <td>{{ $person->experience }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div style="width: 49%;float: right;">
                    <div style="height: 50px;line-height: 50px;text-align: left;">军团榜</div>
                    <table>
                        <tr><th>榜</th><th>军团</th><th>总战功</th></tr>
                        @foreach($groups as $key => $group)
                        <tr>
                            <td>@if(($key + 1) == 1) <span style="color:#eead0e">冠军</span> @elseif(($key + 1) == 2) <span style="color:#cdc1c5">亚军</span> @elseif(($key + 1) == 3) <span style="color:#cd950c">季军</span> @else  {{ $key + 1 }}  @endif</td>
                            <td>@if($group->group_id) {{ \DB::table('groups')->find($group->group_id)->name }} @else 未知 @endif</td>
                            <td>{{ $group->total }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div style="clear:both;"></div>
    		</td>
    	</tr>
    	<!-- <tr>
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
    	</tr> -->
    </table>
@endsection