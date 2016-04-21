@extends('admin.layouts.master')

@section('content')
    <div class="title">
        <h2>新增</h2> <a href="{{ route('group') }}" class="btn-info">所有军团</a>
    </div>
    <form action="{{ route('postGroup') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <table class="add">
            <tr>
                <td width="200">名称</td><td><input type="text" name="name" value=""></td>
            </tr>
            <tr>
                <td width="200">级别</td>
                <td>
                    <select class="" name="level">
                        <option value="1">军团</option>
                        <option value="2">小组</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="200">所属</td>
                <td>
                    <select class="" name="pid">
                        <option value="0">顶级</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td width="200">状态</td>
                <td>
                    <input type="radio" name="status" value="1" checked="checked"> 开启
                    <input type="radio" name="status" value="0"> 关闭
                </td>
            </tr>
            <tr>
                <td width="200"></td>
                <td><button type="submit" class="btn-info">保存</button></td>
            </tr>
        </table>
    </form>
@endsection
