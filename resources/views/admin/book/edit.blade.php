@extends('layouts.admin')
@section('content')
    <book-edit
        :data="{{json_encode([
            'urlUpdate' =>route('book.update',$book->id),
            'book' => $book,
            'title' => $title,
    ]) }}">
    </book-edit>
@endsection
