@extends('layouts.app')
@section('content')
<div>
<prete-add :dioceses='@json($dioceses)'/>
</div>
@endsection
