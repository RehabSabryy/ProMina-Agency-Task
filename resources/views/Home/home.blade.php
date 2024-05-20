@extends('Layout.main')
@section('content')
 <!-- display all albums with their pictures -->
 <div class="container">
    <h1 class="text-center text-danger mt-5">All Albums</h1>
    <div class="d-flex flex-wrap">
        @foreach($albums as $album)
          <div class="card mx-5 my-3 w-25">
            <div class="card-body d-flex flex-column justify-content-between">
                <h2 class="fs-4 text-center">{{$album->album_name}}</h2>
                <div id="carousel{{$album->id}}" class="carousel slide">
                    <div class="carousel-inner">
                        @foreach ($album->pictures as $key => $picture)
                            <div class="carousel-item {{$key == 0 ? 'active' : ''}}">
                                <img src="{{ Storage::url($picture->path) }}" class="d-block w-100" alt="Album Picture">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{$album->id}}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel{{$album->id}}" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <div class="btns d-flex justify-content-center my-3">
                    <a class="btn btn-danger me-2" href="{{ route('albums.edit', $album) }}">Edit</a>
                    <button class="btn btn-dark" onclick="deleteAlbum({{$album->id}})">Delete</button>
                </div>
        </div>       
    </div>
 @endforeach
@endsection

<script>
    function deleteAlbum(albumId) {
        if (confirm("Are you sure you want to delete this album?")) {
            let answer = prompt("Do you want to \n1 - Delete all the pictures in the album \n2 - Move all the pictures to another album");
            if (answer == '1') {
                window.location.href = '/albums/' + albumId + '/delete-all';
            } else if (answer == '2') {
                let targetAlbumId = prompt("Enter the id of the album you want to move the pictures to:");
                if (targetAlbumId) {
                    //HTTP POST request to move the pictures
                    fetch('/albums/' + albumId + '/move', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ target_album_id: targetAlbumId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = '/';
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            }
        }
    }
</script>
