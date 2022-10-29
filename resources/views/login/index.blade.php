@extends('layouts.guest')

@section('content')
    <login :data="{{ json_encode([
        'request' => $request,
        'message' => $message ?? '',
        'urlBack' => route('homePage'),
    ]) }}"></login>

@endsection
