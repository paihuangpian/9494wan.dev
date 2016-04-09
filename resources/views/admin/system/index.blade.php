@extends('admin.layouts.master')

@section('sidebar')
    @include('admin.system.sidebar')
@endsection

@section('content')
    <div class="title">
        <h2>菜单</h2> <a href="{{ route('addMenu') }}" class="btn-info">新增</a> <a href="#" class="btn-info">导出Excel</a>
    </div>
    <div class="filter">
        <a href="#" class="active">全部<small>({{ count($menus) }})</small></a><span class="sep">/</span><a href="#">已启用<small>(5)</small></a>
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
            <th>用户名</th>
            <th>用户组</th>
            <th>操作</th>
        </tr>
        @foreach($menus as $key => $menu)
        <tr>
            <td><input type="checkbox" name="name" value=""></td>
            <td>{{ $key+1 }}</td>
            <td>{{ $menu->name }}</td>
            <td>{{ $menu->route }}</td>
            <td><a href="#">编辑</a></td>
        </tr>
        @endforeach
    </table>
    <div class="action">
        翻页
    </div>
@endsection
