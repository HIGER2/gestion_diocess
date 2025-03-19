@extends('layouts.appAuth')
@section('content')
<div>
    <inscription-page :diocese='{{json_encode($diocese)}}' :dioceses='@json($dioceses)' />
</div>
@endsection
