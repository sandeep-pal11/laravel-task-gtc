@extends('user.layouts.app')

@section('title', 'Profile')

@section('content')

@php
    $user = auth()->user();
    $isSocialUser = $user->provider !== null;
@endphp

<h1 class="mt-4">Profile</h1>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-user me-1"></i> Profile Information
    </div>
    <div class="card-body">
        @include('profile.partials.update-profile-information-form')
    </div>
</div>

@if(!$isSocialUser)
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-lock me-1"></i> Change Password
    </div>
    <div class="card-body">
        @include('profile.partials.update-password-form')
    </div>
</div>
@endif

@if($isSocialUser)
<div class="alert alert-info">
    You logged in using <b>{{ ucfirst($user->provider) }}</b>.
    Password change is disabled.
</div>
@endif

<div class="card border-danger">
    <div class="card-header bg-danger text-white">
        <i class="fas fa-trash me-1"></i> Delete Account
    </div>
    <div class="card-body">
        @include('profile.partials.delete-user-form')
    </div>
</div>

@endsection
