@extends('layouts.app')

@section('content')
    <conversations-dashboard
            :id="{{ isset($conversation) ? $conversation->id : 'null' }}"
    >
    </conversations-dashboard>
@endsection
