@extends('layouts.Helloapp')

@section('content')
<h2>User Management System</h2>
<div class="hello-actions">
    <a href="/hello/add" class="btn btn-add">新規登録</a>
    <a href="/hello/reset" class="btn btn-reset">リセット（全削除）</a>
    <a href="/hello/dummy" class="btn btn-dummy">ダミーデータを入れる</a>
</div>
<table>
    <tr><th>Name</th><th>Mail</th><th>Age</th><th>Edit</th><th>Delete</th></tr>
    @foreach($items as $item)
    <tr>
        <td>{{ $item->name }}</td>
        <td>{{ $item->mail }}</td>
        <td>{{ $item->age }}</td>
        <td><a href="/hello/edit?id={{ $item->id }}">edit</a></td>
        <td><a href="/hello/del?id={{ $item->id }}">delete</a></td>
    </tr>
    @endforeach
</table>
@endsection
