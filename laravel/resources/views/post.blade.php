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

    <form method="POST" action="{{ route('post') }}">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
        </div>
        <select class="form-select" aria-label="Default select example" name="status">
            <option selected></option>
            @foreach($statuses as $status)
                <option value="{{ $status->id }}">{{ $status->display_name }}</option>
            @endforeach


        </select>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<div class="shadow container mt-4 mb-5 p-4">
    <h2 class="mb-3">Posts</h2>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Created At</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- <tr>
                <td colspan="4" class="text-center text-muted">No records yet</td>
            </tr> -->
            @foreach($posts as $post) 
            <tr>
                <!-- [(title1, description1, created_at1, status1),
                    (title2, description2, created_at2, status2),
                    ...
                ] -->
                <td> {{ $post->title }} </td>
                <td> {{ $post->description }} </td>
                <td> {{ $post->created_at }} </td>
                <td> {{ $post->status_name }} </td>
                <td>
                    @if($post->sname != 'published')
                        <a href="" class="bi bi-pencil-square"></a>
                    @endif

                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>
@endsection