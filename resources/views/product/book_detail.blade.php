@extends('layouts.admin')

@section('content')
    <book-detail  :data="{{ json_encode([
        'book' => $book,
        'urlStore' => route('product.store'),
        'comments' => $comments,
        'urlStoreComment' => route('user.addComment'),
        'urlGetComments' => route('user.getComment'),
        'urlEvaluate' => route('product.evaluate'),

]) }}">
    </book-detail>
@endsection
