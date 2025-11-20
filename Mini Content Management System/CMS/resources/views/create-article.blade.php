@extends('layouts.primary')

@section('content')



    <form id="articleForm" method="POST" action="/article/create">
        @csrf
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="teaser">Teaser:</label>
            <input type="text" id="teaser" name="teaser" required>
        </div>
        <div>
            <label for="body">Body:</label>
            <textarea id="body" name="body" required></textarea>
        </div>
        <button type="submit">Create Article</button>
    </form>

    <div id="articleMessage" style="color:green; margin-top:10px;"></div>
        
@endsection