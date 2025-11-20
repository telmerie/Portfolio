<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;


class CategoryController extends Controller
{
    public function createCategory(Request $request)
    {
        $incomingFields = $request->validate([
            'name' => 'required|string|max:255',
            'article_id' => 'nullable|exists:articles,id',
        ]);

        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['user_id'] = auth()->id();

        $category = Category::create($incomingFields);


        if (!empty($incomingFields['article_id'])) {
            $article = Article::find($incomingFields['article_id']);
            $article->categories()->syncWithoutDetaching([$category->id]);
        }

        return response()->json([
            'message' => 'Category created successfully!',
            'category' => $category,
        ]);
    }

    public function attachCategory(Request $request)
    {
        $fields = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $article = Article::find($fields['article_id']);
        $article->categories()->syncWithoutDetaching([$fields['category_id']]);

        return response()->json([
            'message' => 'Category attached successfully!',
        ]);
    }

    public function detachCategory(Request $request)
    {
        $fields = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $article = Article::findOrFail($fields['article_id']);
        $article->categories()->detach($fields['category_id']);

        return response()->json([
            'message' => 'Category removed from article'
        ]);
    }


}
