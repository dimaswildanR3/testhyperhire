<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\LikedController;

Route::get('/recommendations', [RecommendationController::class, 'index']);
Route::get('/people/{id}', [RecommendationController::class, 'show']);

Route::post('/people/{id}/like', [ReactionController::class, 'like']);
Route::post('/people/{id}/dislike', [ReactionController::class, 'dislike']);

Route::get('/liked', [LikedController::class, 'index']);
