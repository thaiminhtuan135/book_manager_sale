
@extends('layouts.guest')
@section('content')

            <register
                :data="{{json_encode([
            'urlStore' => route('register.store'),
            'urlBack' => route('homePage'),
            'urlCheckMail' => route('register.checkEmail'),
            'GOOGLE_RECAPTCHAR_V2' => env('GOOGLE_SECRET_KEY_V2'),
            'GOOGLE_PUBLIC_KEY_V2' => env('GOOGLE_PUBLIC_KEY_V2'),
            'name' => __('Full name'),
            'address' => __('Address'),
            'dob' => __('dob'),
            'phoneNumber' => __('Phone number'),
            'email' => __('Email'),
            'password' => __('Password'),
            'registration' => __('User registration'),
            'nameBlank' => __('nameBlank'),
            'requiredAddress' => __('requiredAddress'),
            'requiredDob' => __('requiredDob'),
            'requiredPhoneNumber' => __('requiredPhoneNumber'),
            'requiredEmail' => __('requiredEmail'),
            'requiredPassword' => __('requiredPassword'),
            'formatPhoneNumber' => __('formatPhoneNumber'),
            'onlyNumber' => __('onlyNumber'),
            'formatDob' => __('formatDob'),
            'formatEmail' => __('formatEmail'),
            'uniqueEmail' => __('uniqueEmail'),
            'minPassword' => __('minPassword'),
            'max255' => __('max255'),
            'SignIn' => __('SignIn'),
            'Back' => __('Back'),
            'EmailEntered' => __('EmailEntered'),


        ])  }}">
            </register>
@endsection
