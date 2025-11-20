<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Models\Article;
use App\Models\Category;

Route::get('/', function () {
    return view('home', ['articles' => Article::all()]);
})->name('home');

Route::get('/error', function() {
    return view('error');
});

Route::get('/create-article', function () {
    return view('create-article', ['categories' => Category::all()]);
})->name('create.article');



Route::post('/login',[UserController::class, 'login']);
Route::post('/logout',[UserController::class, 'logout']);
Route::get('/createUser', function() {return view('create-user');})->name('create.user');
Route::post('/createUser',[UserController::class, 'createUser']);
Route::post('/article/create', [ArticleController::class, 'createArticle']);
Route::get('/article/edit/{article}', [ArticleController::class, 'editArticle'])->name('article.edit');
Route::put('/article/edit/{article}', [ArticleController::class, 'saveEdit']);
Route::delete('/article/delete/{article}', [ArticleController::class, 'deleteArticle']);
Route::get('/article/get/{article}', [ArticleController::class, 'getArticle']);
Route::post('/article/add-category', [ArticleController::class, 'addCategory']);

//category routes
Route::post('/category/create', [CategoryController::class, 'createCategory']);
Route::post('/category/attach', [CategoryController::class, 'attachCategory'])
    ->name('category.attach');
Route::delete('/category/detach', [CategoryController::class, 'detachCategory']);
