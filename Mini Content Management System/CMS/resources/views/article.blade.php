@extends('layouts.primary')

@section('content')

    <h2>{{$article->title}}</h2>

    <h3>{{$article->teaser}}</h3>   
    <p>{{$article->body}}</p>
    
@endsection