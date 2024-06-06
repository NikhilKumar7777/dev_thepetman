<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
Route::view('/', 'welcome');
Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');
Route::get('checkEmail/{token}','EmailSender@checkMail')->name('checkMail');
Route::get('approvalEmail/{token}','EmailSender@approval')->name('approval');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Post
    Route::delete('posts/destroy', 'PostController@massDestroy')->name('posts.massDestroy');
    Route::post('posts/media', 'PostController@storeMedia')->name('posts.storeMedia');
    Route::post('posts/ckmedia', 'PostController@storeCKEditorImages')->name('posts.storeCKEditorImages');
    Route::resource('posts', 'PostController');

    // Categories
    Route::delete('categories/destroy', 'CategoriesController@massDestroy')->name('categories.massDestroy');
    Route::post('categories/media', 'CategoriesController@storeMedia')->name('categories.storeMedia');
    Route::post('categories/ckmedia', 'CategoriesController@storeCKEditorImages')->name('categories.storeCKEditorImages');
    Route::resource('categories', 'CategoriesController');

    // Animals
    Route::delete('animals/destroy', 'AnimalsController@massDestroy')->name('animals.massDestroy');
    Route::post('animals/media', 'AnimalsController@storeMedia')->name('animals.storeMedia');
    Route::post('animals/ckmedia', 'AnimalsController@storeCKEditorImages')->name('animals.storeCKEditorImages');
    Route::resource('animals', 'AnimalsController');

    // Answer
    Route::delete('answers/destroy', 'AnswerController@massDestroy')->name('answers.massDestroy');
    Route::resource('answers', 'AnswerController');

    // Reports Abuse
    Route::delete('reports-abuses/destroy', 'ReportsAbuseController@massDestroy')->name('reports-abuses.massDestroy');
    Route::resource('reports-abuses', 'ReportsAbuseController');

    // Vote
    Route::delete('votes/destroy', 'VoteController@massDestroy')->name('votes.massDestroy');
    Route::resource('votes', 'VoteController');

    // Comment
    Route::delete('comments/destroy', 'CommentController@massDestroy')->name('comments.massDestroy');
    Route::resource('comments', 'CommentController');

    // Follow
    Route::delete('follows/destroy', 'FollowController@massDestroy')->name('follows.massDestroy');
    Route::resource('follows', 'FollowController');

    // Pet
    Route::delete('pets/destroy', 'PetController@massDestroy')->name('pets.massDestroy');
    Route::resource('pets', 'PetController');

    // User Address
    Route::delete('user-addresses/destroy', 'UserAddressController@massDestroy')->name('user-addresses.massDestroy');
    Route::resource('user-addresses', 'UserAddressController');

    // Team
    Route::delete('teams/destroy', 'TeamController@massDestroy')->name('teams.massDestroy');
    Route::resource('teams', 'TeamController');

    // Breed
    Route::delete('breeds/destroy', 'BreedController@massDestroy')->name('breeds.massDestroy');
    Route::post('breeds/parse-csv-import', 'BreedController@parseCsvImport')->name('breeds.parseCsvImport');
    Route::post('breeds/process-csv-import', 'BreedController@processCsvImport')->name('breeds.processCsvImport');
    Route::resource('breeds', 'BreedController');

    // Likes
    Route::delete('likes/destroy', 'LikesController@massDestroy')->name('likes.massDestroy');
    Route::post('likes/parse-csv-import', 'LikesController@parseCsvImport')->name('likes.parseCsvImport');
    Route::post('likes/process-csv-import', 'LikesController@processCsvImport')->name('likes.processCsvImport');
    Route::resource('likes', 'LikesController');

    // Dislike
    Route::delete('dislikes/destroy', 'DislikeController@massDestroy')->name('dislikes.massDestroy');
    Route::post('dislikes/parse-csv-import', 'DislikeController@parseCsvImport')->name('dislikes.parseCsvImport');
    Route::post('dislikes/process-csv-import', 'DislikeController@processCsvImport')->name('dislikes.processCsvImport');
    Route::resource('dislikes', 'DislikeController');

    // Views
    Route::delete('views/destroy', 'ViewsController@massDestroy')->name('views.massDestroy');
    Route::post('views/parse-csv-import', 'ViewsController@parseCsvImport')->name('views.parseCsvImport');
    Route::post('views/process-csv-import', 'ViewsController@processCsvImport')->name('views.processCsvImport');
    Route::resource('views', 'ViewsController');

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');
    Route::get('team-members', 'TeamMembersController@index')->name('team-members.index');
    Route::post('team-members', 'TeamMembersController@invite')->name('team-members.invite');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Post
    Route::delete('posts/destroy', 'PostController@massDestroy')->name('posts.massDestroy');
    Route::post('posts/media', 'PostController@storeMedia')->name('posts.storeMedia');
    Route::post('posts/ckmedia', 'PostController@storeCKEditorImages')->name('posts.storeCKEditorImages');
    Route::resource('posts', 'PostController');

    // Categories
    Route::delete('categories/destroy', 'CategoriesController@massDestroy')->name('categories.massDestroy');
    Route::post('categories/media', 'CategoriesController@storeMedia')->name('categories.storeMedia');
    Route::post('categories/ckmedia', 'CategoriesController@storeCKEditorImages')->name('categories.storeCKEditorImages');
    Route::resource('categories', 'CategoriesController');

    // Animals
    Route::delete('animals/destroy', 'AnimalsController@massDestroy')->name('animals.massDestroy');
    Route::post('animals/media', 'AnimalsController@storeMedia')->name('animals.storeMedia');
    Route::post('animals/ckmedia', 'AnimalsController@storeCKEditorImages')->name('animals.storeCKEditorImages');
    Route::resource('animals', 'AnimalsController');

    // Answer
    Route::delete('answers/destroy', 'AnswerController@massDestroy')->name('answers.massDestroy');
    Route::resource('answers', 'AnswerController');

    // Reports Abuse
    Route::delete('reports-abuses/destroy', 'ReportsAbuseController@massDestroy')->name('reports-abuses.massDestroy');
    Route::resource('reports-abuses', 'ReportsAbuseController');

    // Vote
    Route::delete('votes/destroy', 'VoteController@massDestroy')->name('votes.massDestroy');
    Route::resource('votes', 'VoteController');

    // Comment
    Route::delete('comments/destroy', 'CommentController@massDestroy')->name('comments.massDestroy');
    Route::resource('comments', 'CommentController');

    // Follow
    Route::delete('follows/destroy', 'FollowController@massDestroy')->name('follows.massDestroy');
    Route::resource('follows', 'FollowController');

    // Pet
    Route::delete('pets/destroy', 'PetController@massDestroy')->name('pets.massDestroy');
    Route::resource('pets', 'PetController');

    // User Address
    Route::delete('user-addresses/destroy', 'UserAddressController@massDestroy')->name('user-addresses.massDestroy');
    Route::resource('user-addresses', 'UserAddressController');

    // Team
    Route::delete('teams/destroy', 'TeamController@massDestroy')->name('teams.massDestroy');
    Route::resource('teams', 'TeamController');

    // Breed
    Route::delete('breeds/destroy', 'BreedController@massDestroy')->name('breeds.massDestroy');
    Route::resource('breeds', 'BreedController');

    // Likes
    Route::delete('likes/destroy', 'LikesController@massDestroy')->name('likes.massDestroy');
    Route::resource('likes', 'LikesController');

    // Dislike
    Route::delete('dislikes/destroy', 'DislikeController@massDestroy')->name('dislikes.massDestroy');
    Route::resource('dislikes', 'DislikeController');

    // Views
    Route::delete('views/destroy', 'ViewsController@massDestroy')->name('views.massDestroy');
    Route::resource('views', 'ViewsController');

    Route::get('frontend/profile', 'ProfileController@index')->name('profile.index');
    Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');
});
