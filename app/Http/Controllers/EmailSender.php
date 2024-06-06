<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use App\Notifications\EmailSenderNotify;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class EmailSender extends Controller
{
    public function checkMail($token){
        $checker = User::where('verification_token',$token)->first();
        // $checker= DB::select('select * from users where verification_token = ?', [$token]);
        if($checker){
            Notification::send($checker, new EmailSenderNotify($token));
            return back();
        }
    }
    public function approval($token){

        $user = User::where('verification_token', $token)->first();
        abort_if(!$user, 404);

        $user->verified           = 1;
        $user->verified_at        = Carbon::now()->format(config('panel.date_format') . ' ' . config('panel.time_format'));
        $user->verification_token = null;
        $user->save();

        return view('admin.users.index');
    }
}
