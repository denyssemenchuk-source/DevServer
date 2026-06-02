<?php

use App\Http\Controllers\Api\Blog\Admin\CategoryController;
use App\Http\Controllers\Api\Blog\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

$groupData = [
    'namespace' => 'App\Http\Controllers\Api\Blog\Admin',
    'prefix' => 'admin/blog',
];
Route::group($groupData, function () {
    //BlogCategory
    $methods = ['index','store','update','show'];
    Route::apiResource('categories', CategoryController::class)
        ->only($methods)
        ->names('blog.admin.categories');
});

Route::group([ 'namespace' => 'App\Http\Controllers\Api\Blog', 'prefix' => 'blog'], function () {
    Route::apiResource('posts', PostController::class)->names('blog.posts');
});
