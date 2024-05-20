@extends('Layout.main')
@section('content')
 <!-- edit Albums -->
 <div class="container d-flex justify-content-center align-items-center">
            <form class="100vh" action="{{ route('albums.update', $album->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT') 
                @csrf
                <h1>Edit Album</h1>
        <div class="form-group">
            <label for="album-name">Album Name</label>
            <input type="text" class="form-control" id="album-name" name="album_name" value="{{$album->album_name}}">
        </div>
        <div class="form-group ">
            <label for="album-pictures">Upload one or more pictures of the allbum</label>
            <input type="file" class="form-control" id="album-pictures" name="path[]" multiple>
        </div>
        <div>
            <p>Uploaded Pictures</p>
            <div class="d-flex flex-wrap flex-row">
            @foreach($album->pictures as $picture)
                    <!-- check if user want to delete image  -->
                    <div class="d-flex flex-column">
                        <p>Select the pictures you want to delete</p>
                        <input type="checkbox" name="delete[]" value="{{ $picture->id }}">
                        <img  src="{{ Storage::url($picture->path) }}" style="height: 200px" class=" m-3"  alt="Album Picture">
                    </div>                        
            @endforeach
            </div>
        </div>
        <input type="submit" class="btn btn-danger m-4">Edit Album</input>

        </form>
</div>
@endsection