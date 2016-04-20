@extends('admin.layouts.master')

@section('content')
    <div class="title">
        <h2>组织</h2> <a href="{{ route('addGroup') }}" class="btn-info">新增</a> <!-- <a href="#" class="btn-info">导出Excel</a> -->
    </div>
    <div class="filter">
        <a href="#" class="active">全部<small>({{ count($groups) }})</small></a><span class="sep">/</span><a href="#">已启用<small>(5)</small></a><span class="sep">/</span><a href="#">未启用<small>(0)</small></a>
    </div>
    <div class="action">
        全选：
        <select class="" name="">
            <option value="option">删除</option>
        </select>
    </div>
    <table>
        <tr>
            <th width="30"><input type="checkbox" name="name" value=""></th>
            <th>序号</th>
            <th>名称</th>
            <th>级别</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        @foreach($groups as $key => $group)
        <tr>
            <td><input type="checkbox" name="name" value=""></td>
            <td>{{ $key+1 }}</td>
            <td>{{ $group->name }}</td>
            <td>@if($group->level == 1) 军团 @else 小组 @endif</td>
            <td>@if($group->status) <span class="green">已启用</span> @else <span class="red">未启用</span> @endif</td>
            <td><a href="#">编辑</a></td>
        </tr>
        @endforeach
    </table>
    <div class="action">
        翻页
    </div>
@endsection
