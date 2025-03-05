@extends('layouts.app')
@section('content')
<div>
    <user-page :user="{{json_encode($user)}}"  />
</div>
@endsection
