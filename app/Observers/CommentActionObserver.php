<?php

namespace App\Observers;

use App\Models\Comment;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;

class CommentActionObserver
{
    public function created(Comment $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'Comment'];
        $users = \App\Models\User::whereHas('roles', function ($q) { return $q->where('title', 'Admin'); })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }
}
