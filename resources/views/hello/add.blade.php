@extends('layouts.Helloapp')


@section('title', 'add')

@section('menubar')
@parent
新規作成ページ
@endsection

@section('content')
<h2>新規作成ページ</h2>
<div class="hello-form-wrap">
    <form action="/hello/add" method="post" class="hello-form">
        @csrf
        <div class="form-row">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="名前を入力" />
        </div>
        <div class="form-row">
            <label for="mail">Mail</label>
            <input type="text" name="mail" id="mail" value="{{ old('mail') }}" placeholder="メールアドレスを入力" />
        </div>
        <div class="form-row">
            <label for="age">Age</label>
            <input type="number" name="age" id="age" value="{{ old('age') }}" placeholder="年齢" min="0" />
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-submit">送信</button>
            <a href="/hello" class="btn-cancel">キャンセル</a>
        </div>
    </form>
</div>
@endsection

@section('footer')
copyright 2026 iwamoto.
@endsection