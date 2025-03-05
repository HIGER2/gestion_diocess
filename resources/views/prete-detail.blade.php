@extends('layouts.app')
@section('content')
<div>
     <prete-detail-page :prete="{{json_encode($prete)}}" />

</div>
@endsection
