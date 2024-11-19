@extends('layouts.app')
@section('content')
<div>
   <diocesse-detail-page :diocese_id='@json($diocese_id)' />
</div>
@endsection
