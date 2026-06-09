@extends('common.header')

@section('title')
Dashboard
@endsection

@section('content')

<div class='container mt-5'>
    <div class="row mb-3">
    @foreach($users as $user)
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card mb-3 h-100 d-flex flex-column">
                        <img class="card-img-top" src="..." alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{ $user->fname }}</h5> {{-- user's name --}}
                            <ul>
                                <li>Email: {{ $user->email }}</li>
                                <li>Middle Name: {{ $user->mname }}</li>
                                <li>Last Name: {{ $user->lname }}</li>
                                @if($user->user_type != null)
                                    <li>User Type: {{ $user->display_name }}</li>
                                @endif
                            </ul>
                            <a href="{{ route('editUser', ['id' => $user->id]) }}" class="btn btn-primary">Edit Info</a> 
                        </div>
                    </div>
                </div>
        @endforeach
        </div>
</div>

@endsection