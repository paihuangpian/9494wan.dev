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
            <!-- <th width="30"><input type="checkbox" name="name" value=""></th> -->
            <th>团号</th>
            <th>名称(人数)</th>
            <th>级别</th>
            <th>状态</th>
            <th>创建</th>
            <th>操作</th>
        </tr>
        @foreach($groups as $key => $group)
        <tr>
            <!-- <td><input type="checkbox" name="name" value=""></td> -->
            <td>{{ $key + 1 }}</td>
            <td><span class="blue">{{ $group->name }}</span> <a href="" class="grey">100</a></td>
            <td>军团</td>
            <td>@if($group->status) 已启用 @else <span class="red">未启用</span> @endif</td>
            <td>{{ $group->created_at }}</td>
            <td><a href="#" class="grey">编辑</a><span class="sep">/</span><a href="" class="grey">删除</a></td>
        </tr>
            @foreach($group->child as $key_child => $child)
            <tr>
                <!-- <td><input type="checkbox" name="name" value=""></td> --> 
                <td></td>
                <!-- <td><div style="border-left: solid 1px #ddd;text-indent:0;line-height: 50px;margin-left: 10px;"><span style="color: #ddd">——</span>{{ $child->name }} <a href="" class="grey">100</a></div></td> -->
                <td style="text-indent: 40px">{{ $key_child + 1 }} - {{ $child->name }} <a href="" class="grey">100</a></td>
                <td>小组</td>
                <td>@if($child->status) 已启用 @else <span class="red">未启用</span> @endif</td>
                <td>{{ $group->created_at }}</td>
                <td><a href="#" class="grey">编辑</a><span class="sep">/</span><a href="" class="grey">删除</a></td>
            </tr>
            @endforeach
        @endforeach
    </table>
    <!-- <div class="action">
        翻页
    </div> -->
@endsection
