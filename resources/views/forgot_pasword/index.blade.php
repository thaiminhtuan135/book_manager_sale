@extends('layouts.guest')

@section('content')
    <forgot-password :data="{{ json_encode([
        'request' => $request,
        'urlStore' => route('forgot_password.store'),
        'message' => $message ?? '',

    ]) }}">
    </forgot-password>
@endsection
