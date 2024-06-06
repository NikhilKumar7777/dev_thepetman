<?php

namespace App\Observers;

use App\Models\Post;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;

class PostActionObserver
{
    public function created(Post $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'Post'];
        $users = \App\Models\User::whereHas('roles', function ($q) { return $q->where('title', 'Admin'); })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }
}
