@extends('layouts.guest')

@section('content')
   <register
       :data="{{json_encode([
            'urlStore' => route('register.store'),
            'urlBack' => route('homePage'),
            'urlCheckMail' => route('register.checkEmail')
        ])  }}">
   </register>

@endsection
