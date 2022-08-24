@extends('layouts.guest')

@section('content')
    <login :data="{{ json_encode([
    'request' => $request,
    'message' => $message ?? '',
]) }}"></login>

@endsection
