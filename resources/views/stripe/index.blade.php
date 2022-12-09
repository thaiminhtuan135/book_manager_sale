@extends('layouts.admin')

@section('content')
    <stripe :data="{{ json_encode([
            'products' => $product,
        ]) }}"
    ></stripe>
@endsection
