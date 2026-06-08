@extends('common.header')

@section('title')
Login Page
@endsection

@section('content')
<div class="container mt-5">
    <form method="POST" action="{{ route('submitEdit', ['id'=> $id]) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="fname" class="form-label">First Name:</label>
            <input type="text" class="form-control" id="fname" name="fname">
        </div>
        <div class="mb-3">
            <label for="mname" class="form-label">Middle Name:</label>
            <input type="text" class="form-control" id="mname" name="mname">
        </div>
        <div class="mb-3">
            <label for="lname" class="form-label">Last Name:</label>
            <input type="text" class="form-control" id="lname" name="lname">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Edit User</button>
    </form>
</div>
@endsection