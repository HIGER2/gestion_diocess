@extends('layouts.app')
@section('content')
<div>
    <utilisateur-page dioceses='@json($dioceses)' />
</div>
@endsection
