<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Laravel 后台管理系统</title>
        <link href="http://cdn.bootcss.com/normalize/3.0.3/normalize.min.css" rel="stylesheet">
        <link href="/css/admin.css" rel="stylesheet">
    </head>
    <body>
        <div class="nav">
            <a href="javascript:;" class="brand">Laravel</a>
            <ul>
                <li><a href="" class="active">仪表盘</a></li>
            </ul>
        </div>
        <div class="sidebar">
            <a href="{{ url('admin') }}" class="active">管理员</a>
            <a href="#">用户组</a>
            <a href="#">菜单</a>
            <a href="">数据库</a>
        </div>
        <div class="container">
            <div class="title"><a href="#" class="active">所有管理员<small>(98)</small></a> <span>/</span> <a href="#">激活用户<small>(78)</small></a></div>
            <div class="action">
                全选：
                <select class="" name="">
                    <option value="option">删除</option>
                </select>
                <input type="text" name="name" value="">
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
        </div>
    </body>
</html>
