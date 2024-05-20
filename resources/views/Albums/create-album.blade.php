@extends('Layout.main')

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <form action="{{ route('albums.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1 class="fs-2">Create Album</h1>
        <div class="form-group mb-3">
            <label for="album-name">Album Name</label>
            <input type="text" class="form-control" id="album-name" name="album_name" placeholder="Enter Album Name" required>
        </div>
        <div class="form-group">
            <label for="album-pictures mb-1">Upload one or more pictures of the album</label>
            <input type="file" class="form-control" id="album-pictures" name="path[]" multiple required>
        </div>
        <input type="submit" class="btn btn-danger m-4" value="Create Album"/>
    </form>
</div>
@endsection
