@extends('admin.layouts.master')

@section('content')
    <div class="title">
        <h2>编辑</h2> <a href="{{ route('group') }}" class="btn-info">所有军团</a>
    </div>
    <form action="{{ route('updateGroup') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{ $group->id }}">
        <table class="add">
            <tr>
                <td width="200">名称</td><td><input type="text" name="name" value="{{ old('name', $group->name) }}"></td>
            </tr>
            @if($group->level == 2)
            <tr>
                <td width="200">所属</td>
                <td>
                    <select class="" name="pid">
                        @foreach($groups as $val)
                            <option value="{{ $val->id }}" @if($group->pid == $val->id) selected @endif>{{ $val->name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            @endif
            <tr>
                <td width="200">状态</td>
                <td>
                    <input type="radio" name="status" value="1" @if($group->status) checked="checked" @endif> 开启
                    <input type="radio" name="status" value="0" @if(!$group->status) checked="checked" @endif> 关闭
                </td>
            </tr>
            <tr>
                <td width="200"></td>
                <td><button type="submit" class="btn-info">保存</button></td>
            </tr>
        </table>
    </form>
@endsection
