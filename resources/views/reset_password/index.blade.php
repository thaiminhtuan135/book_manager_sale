@extends('layouts.guest')

@section('content')
    <reset-password :data="{{ json_encode([
        'request' => $request,
        'message' => $message ?? '',
        'urlStore' => route('reset_password.store'),
        'password1' => __('Password'),
        'backHome' => __('Back'),
        'requiredPassword' => __('requiredPassword'),
        'minPassword' => __('minPassword'),
    ]) }}"></reset-password>
@endsection
