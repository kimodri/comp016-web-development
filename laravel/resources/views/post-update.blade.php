@extends("common.main")

@section("title", "Post Form")

@section("content")
<div class="shadow container mt-5 p-4">
    <h1 class="mb-4">Create Post</h1>

    @if(session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif

    @if($errors->any())
    @foreach($errors->all() as $error)
    <div class="alert alert-danger" role="alert">
        {{ $error }}
    </div>
    @endforeach
    @endif

    <form method="POST" action="{{ route('post.updateSubmit', $post->id) }}">
        @csrf
        @method('PUT')
        <input type = "hidden" value="$post->id" name='id'>
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ $post->title }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4" value="{{ $post->description }}">{{ $post->description }}</textarea>
        </div>
        <select class="form-select" aria-label="Default select example" name="status">
            @foreach($statuses as $status)
                @if($post->status == $status->id)
                    <option value="{{ $status->id }}" selected>{{ $status->display_name }}</option>
                @else
                    <option value="{{ $status->id }}">{{ $status->display_name }}</option>
                @endif
            @endforeach


        </select>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

@endsection