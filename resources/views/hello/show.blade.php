@extends('layouts.Helloapp')

@section('title', 'show')

@section('menubar')
@parent
showページ
@endsection

@section('content')
<h2>showページ</h2>
@if(isset($item) && $item->isNotEmpty())
@foreach($item as $person)
<table width="400px">
    <tr><th width="50px">id: </th>
    <td>{{ $person->id }}</td></tr>
    <tr><th width="50px">name: </th>
    <td>{{ $person->name }}</td></tr>
</table>
@endforeach
@else
<p>データがありません。</p>
@endif
@endsection

@section('footer')
@endsection