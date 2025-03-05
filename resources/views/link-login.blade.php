@extends('layouts.appAuth')
@section('content')
<link-login-page :token='{{json_encode($token)}}'/>
@endsection
