@extends('layouts.Helloapp')


@section('title'. 'add')

@section('menubar')
@parent
更新ページ
@endsection

@section('content')
<form action="/hello/edit" method="post">
    @csrf
    <!-- hiddenで、idを隠して、渡す。 -->
    <input type="hidden" name="id" value="{{$form->id}}">
    <label for="name">Name:</label>
    <input type="text" name="name" value="{{$form->name}}" />
    <br />
    <label for="mail">Mail:</label>
    <input type="text" name="mail" value="{{$form->mail}}" />
    <br />
    <label for="age">Age:</label>
    <input type="number" name="age" value="{{$form->age}}" />
    <br />
    <input type="submit" value="send">
</form>
@endsection

@section('footer')
copyright 2026 iwamoto.
@endsection