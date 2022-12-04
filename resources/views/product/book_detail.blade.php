@extends('layouts.admin')

@section('content')
    <book-detail  :data="{{ json_encode([
        'book' => $book,
        'urlStore' => route('product.store'),

]) }}">

    </book-detail>
@endsection
