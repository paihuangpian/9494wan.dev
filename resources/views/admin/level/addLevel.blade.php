@extends('admin.layouts.master')

@section('content')
    <div class="title">
        <h2>新增等级</h2> <a href="{{ route('level') }}" class="btn-info">所有等级</a>
    </div>
    <form action="{{ route('postLevel') }}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <table class="add">
            <tr>
                <td width="200">名称</td><td><input type="text" name="name" value=""></td>
            </tr>
            <tr>
                <td width="200">标志</td><td><input type="file" name="sign" value=""></td>
            </tr>
            <tr>
                <td width="200">所需经验</td><td><input type="text" name="experience" value=""></td>
            </tr>
            <tr>
                <td width="200">所需经验最大值</td><td><input type="text" name="experience_max" value=""> <span class="origin">比如更高一级的经验值是1000，则此值应该是999.99</span></td>
            </tr>
            <tr>
                <td width="200">衰减值</td><td><input type="text" name="attenuation" value=""></td>
            </tr>
            <tr>
                <td width="200">等级工资</td><td><input type="text" name="wages" value=""></td>
            </tr>
            <tr>
                <td width="200">消费百分比</td><td><input type="text" name="commission" value="">
                <span class="origin">比如：0.12</span></td>
            </tr>
            <tr>
                <td width="200">带薪休假天数</td><td><input type="text" name="vacation" value=""></td>
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
