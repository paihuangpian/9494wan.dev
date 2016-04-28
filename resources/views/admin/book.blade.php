@extends('admin.layouts.master')

@section('content')
    <div class="title">
        <h2>留言</h2>
    </div>
    <table>
        <tr>
            <th>序号</th>
            <th>员工</th>
            <th>内容</th>
            <th>时间</th>
        </tr>
        @foreach($books as $key => $book)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td><span class="blue">{{ \DB::table('users')->find($book->user_id)->name }}</span></td>
            <td>{{ $book->content }}</td>
            <td>{{ date('Y-m-d', time($book->created_at)) }}</td>
        @endforeach
    </table>
@endsection
