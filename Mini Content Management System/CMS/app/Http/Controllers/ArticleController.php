<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    public function createArticle(Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'teaser' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['teaser'] = strip_tags($incomingFields['teaser']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();
        $article = Article::create($incomingFields);
        return redirect('/article/edit/' . $article->id);
    }

    public function getArticles() {
        return Article::all();
    }

    public function editArticle(Article $article) {
        if (auth()->user()->id !== $article['user_id']) {
            return redirect('/');
        }


        $usedCategories = $article->categories;
        $availableCategories = Category::whereDoesntHave('articles', function($query) use ($article) {
        $query->where('article_id', $article->id);
        })->get();

        return view('edit-article', compact('article', 'availableCategories', 'usedCategories'));
    }

    public function saveEdit(Article $article, Request $request) {
        if (auth()->user()->id !== $article['user_id']) {
            return redirect('/');
        }

        $incomingFields = $request->validate([
            'title' => 'required',
            'teaser' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['teaser'] = strip_tags($incomingFields['teaser']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);
        return redirect('/');
    }

    public function deleteArticle(Article $article) {
        if (auth()->user()->id === $article['user_id']) {
            $article->delete();
        }
        return redirect('/');
    }

    public function getArticle(Article $article) {
        return view('article', ['article' => $article]);
    }
    
        public function addCategory(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $article = Article::find($request->article_id);

        $article->categories()->syncWithoutDetaching([$request->category_id]);

        return response()->json([
            'message' => 'Category added to article successfully!',
        ]);
    }


}
