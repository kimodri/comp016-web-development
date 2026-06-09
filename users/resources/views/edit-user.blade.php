@extends('common.header')

@section('title')
Edit Page
@endsection

@section('content')
<div class="container mt-5">
    <form method="POST" action="{{ route('submitEdit', ['id'=> $id]) }}">
        @csrf
        @method('POST')
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
        <select class="form-select" aria-label="Default select example" name="usertype">
            <option></option>
            @foreach($user_types as $user_type)
                @if($user->user_type == $user_type->id)
                    <option selected value="{{ $user_type->id }}">{{ $user_type->display_name }}</option>
                @else
                    <option value="{{ $user_type->id }}">{{ $user_type->display_name }}</option>
                @endif
            @endforeach

        </select>
        <button type="submit" class="btn btn-primary">Edit User</button>
    </form>
</div>
@endsection