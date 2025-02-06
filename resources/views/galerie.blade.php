<!-- resources/views/gallery.blade.php -->
@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Galerie d'images</h2>
    <div class="row">
        @foreach ($images as $image)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="{{ asset($image->path) }}" class="card-img-top" alt="Image">
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
