@extends('layouts.app')
@section('content')
<div>
   <prete-detail-page :prete_id='@json($prete_id)' />
</div>
@endsection
