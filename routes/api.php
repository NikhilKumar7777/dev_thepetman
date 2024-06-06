<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Users
    Route::apiResource('users', 'UsersApiController');

    // Post
    Route::post('posts/media', 'PostApiController@storeMedia')->name('posts.storeMedia');
    Route::apiResource('posts', 'PostApiController');

    // Categories
    Route::post('categories/media', 'CategoriesApiController@storeMedia')->name('categories.storeMedia');
    Route::apiResource('categories', 'CategoriesApiController');

    // Animals
    Route::post('animals/media', 'AnimalsApiController@storeMedia')->name('animals.storeMedia');
    Route::apiResource('animals', 'AnimalsApiController');

    // Answer
    Route::apiResource('answers', 'AnswerApiController');

    // Reports Abuse
    Route::apiResource('reports-abuses', 'ReportsAbuseApiController');

    // Vote
    Route::apiResource('votes', 'VoteApiController');

    // Comment
    Route::apiResource('comments', 'CommentApiController');

    // Follow
    Route::apiResource('follows', 'FollowApiController');

    // Pet
    Route::apiResource('pets', 'PetApiController');

    // Breed
    Route::apiResource('breeds', 'BreedApiController');

    // Likes
    Route::apiResource('likes', 'LikesApiController');

    // Dislike
    Route::apiResource('dislikes', 'DislikeApiController');

    // Views
    Route::apiResource('views', 'ViewsApiController');
});
