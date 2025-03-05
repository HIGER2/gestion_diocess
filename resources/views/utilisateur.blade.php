@extends('layouts.app')
@section('content')
<div>
    <utilisateur-page :dioceses='{{json_encode($dioceses)}}' />
</div>
@endsection
