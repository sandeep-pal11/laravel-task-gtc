@extends('user.layouts.app')

@section('title','User Dashboard')

@section('content')
<h1>User Dashboard</h1>
<p>Welcome {{ auth()->user()->name }}</p>
@endsection
