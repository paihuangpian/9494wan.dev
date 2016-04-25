@extends('admin.layouts.master')

@section('content')
    <div class="title">
        <h2>编辑等级</h2> <a href="{{ route('level') }}" class="btn-info">所有等级</a>
    </div>
    <form action="{{ route('updateLevel') }}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{ $level->id }}">
        <table class="add">
            <tr>
                <td width="200">名称</td><td><input type="text" name="name" value="{{ old('name', $level->name) }}"></td>
            </tr>
            <tr>
                <td width="200">标志</td><td><input type="file" name="sign" value=""></td>
            </tr>
            @if($level->sign)
                <tr>
                    <td width="200">预览</td><td><img src="/images/sign/{{ $level->sign }}"></td>
                </tr>
            @endif
            <tr>
                <td width="200">所需经验</td><td><input type="text" name="experience" value="{{ old('experience', $level->experience) }}"></td>
            </tr>
            <tr>
                <td width="200">衰减值</td><td><input type="text" name="attenuation" value="{{ old('attenuation', $level->attenuation) }}"></td>
            </tr>
            <tr>
                <td width="200">等级工资</td><td><input type="text" name="wages" value="{{ old('wages', $level->wages) }}"></td>
            </tr>
            <tr>
                <td width="200">消费百分比</td><td><input type="text" name="commission" value="{{ old('commission', $level->commission) }}">
                <span class="origin">比如：0.12</span></td>
            </tr>
            <tr>
                <td width="200">带薪休假天数</td><td><input type="text" name="vacation" value="{{ old('vacation', $level->vacation) }}"></td>
            </tr>
            <tr>
                <td width="200">状态</td>
                <td>
                    <input type="radio" name="status" value="1" @if($level->status) checked="checked" @endif> 开启
                    <input type="radio" name="status" value="0" @if(!$level->status) checked="checked" @endif> 关闭
                </td>
            </tr>
            <tr>
                <td width="200"></td>
                <td><button type="submit" class="btn-info">保存</button></td>
            </tr>
        </table>
    </form>
@endsection
