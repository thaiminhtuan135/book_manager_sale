@extends('layouts.guest')

@section('content')
    <login :data="{{ json_encode([
        'request' => $request,
        'message' => $message ?? '',
        'urlBack' => route('homePage'),
        'login' => __('Log in'),
        'password1' => __('Password'),
        'backHome' => __('Back'),
        'requiredEmail' => __('requiredEmail'),
        'requiredPassword' => __('requiredPassword'),
        'formatEmail' => __('formatEmail'),
        'minPassword' => __('minPassword'),
    ]) }}"></login>
@endsection
