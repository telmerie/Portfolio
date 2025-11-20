@extends('layouts.primary')

@section('content')

    @foreach($articles as $article)
        <div class="article">
            <div >
                <h1 class="title"><a href="/article/get/{{$article->id}}">{{ $article['title'] }}</a></h1>
                <h2 class="teaser">{{ $article['teaser'] }}</h2>
            </div>
            @if(auth()->user() && auth()->user()->id === $article->user_id)
            <div class="article-actions">
                <a href="{{ route('article.edit', $article->id) }}" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ url('/article/delete/'.$article->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" >
                        <i class="fas fa-trash"></i> 
                    </button>
                </form>
                
            </div>
            @endif

        </div>
    @endforeach

@endsection