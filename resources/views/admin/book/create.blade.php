@extends('layouts.admin')

@section('content')
    <book-create
        :data="{{ json_encode([
            'urlStore' => route('book.store'),
            'title' => $title,
            'urlBack' => route('book.index'),
        ]) }}">
    </book-create>
@endsection
