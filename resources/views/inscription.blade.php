@extends('layouts.app')
@section('content')
<div>
    <inscription-page dioceses='@json($dioceses)'/>
</div>
@endsection
