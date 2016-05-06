@extends('admin.layouts.master')

@section('content')
    <div class="title">
        <h2>新增</h2> <a href="{{ route('user') }}" class="btn-info">所有员工</a>
    </div>
    <form action="{{ route('postUser') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <table class="add">
            <tr>
                <td width="200">姓名</td>
                <td>
                    <input type="text" name="name" value="{{ old('name') }}">
                <span class="grey"> 对应的密码是保存之后随机生成的六位密码。</span></td>
            </tr>
            <tr>
                <!-- <td width="200">用户名</td><td><input type="text" name="username" value=""></td> -->
            </tr>
            <tr>
                <td width="200">角色</td>
                <td>
                    <select class="" name="role_id">
                        <option value="0">团长</option>
                        <option value="1">组长</option>
                        <option value="2">组员</option>    
                    </select>
                </td>
            </tr>
            <tr>
                <td width="200">小组</td>
                <td>
                    <select class="" name="group_id">
                        <option value="">未分配</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" disabled="disabled">{{ $group->name }}</option>
                            @foreach($group->child as $child)
                                <option value="{{ $child->id }}">--{{ $child->name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td width="200">状态</td>
                <td>
                    <input type="radio" name="status" value="1" checked="checked"> 在职
                    <input type="radio" name="status" value="0"> 离职
                </td>
            </tr>
            <tr>
                <td width="200">经验</td>
                <td>
                    <input type="text" name="experience" value="0">
                    <span class="grey"> 请参考等级经验值。</span>
                </td>
            </tr>
            <tr>
                <td width="200"></td>
                <td><button type="submit" class="btn-info">保存</button></td>
            </tr>
        </table>
    </form>
@endsection
