@extends('admin.layouts.master')

@section('sidebar')
    <a href="{{ route('menus') }}">站点</a>
    <a href="{{ route('menus') }}">用户</a>
    <a href="{{ route('menus') }}" @if(Route::currentRouteName() == 'menus') class="active" @endif>菜单</a>
    <a href="{{ route('menus') }}">数据</a>
@endsection

@section('title')

@endsection

@section('filter')

@endsection

@section('action-top')

@endsection

@section('content')
    <div class="title">
        <h2>菜单</h2> <a href="{{ route('addMenu') }}" class="btn-info">新增</a> <a href="#" class="btn-info">导出Excel</a>
    </div>
    <div class="filter">
        <a href="#" class="active">全部<small>(98)</small></a><span class="sep">/</span><a href="#">已启用<small>(90)</small></a>
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
        <tr>
            <td><input type="checkbox" name="name" value=""></td>
            <td>1</td>
            <td>admin</td>
            <td>超级管理员</td>
            <td><a href="#">编辑</a></td>
        </tr>
        <tr>
            <td><input type="checkbox" name="name" value=""></td>
            <td>1</td>
            <td>admin</td>
            <td>超级管理员</td>
            <td><a href="#">编辑</a></td>
        </tr>
    </table>
    <div class="action">
        翻页
    </div>
@endsection
