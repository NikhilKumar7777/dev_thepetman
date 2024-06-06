<?php

namespace App\Models;

use \DateTimeInterface;
use App\Notifications\VerifyUserNotification;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    use HasFactory;

    public const PROFILE_STATUS_SELECT = [
        '1' => 'Step 1',
        '2' => 'Step 2',
        '3' => 'Step 3',
        '4' => 'Complete',
    ];

    public $table = 'users';

    protected $hidden = [
        'remember_token',
        'password',
    ];

    protected $dates = [
        'email_verified_at',
        'verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'email_verified_at',
        'password',
        'approved',
        'verified',
        'verified_at',
        'verification_token',
        'remember_token',
        'created_at',
        'social_token',
        'social_platform',
        'profile_status',
        'city',
        'about',
        'bio',
        'age',
        'updated_at',
        'deleted_at',
        'team_id',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (User $user) {
            if (auth()->check()) {
                $user->verified = 1;
                $user->verified_at = Carbon::now()->format(config('panel.date_format') . ' ' . config('panel.time_format'));
                $user->save();
            } elseif (!$user->verification_token) {
                $token = Str::random(64);
                $usedToken = User::where('verification_token', $token)->first();

                while ($usedToken) {
                    $token = Str::random(64);
                    $usedToken = User::where('verification_token', $token)->first();
                }

                $user->verification_token = $token;
                $user->save();

                $registrationRole = config('panel.registration_default_role');
                if (!$user->roles()->get()->contains($registrationRole)) {
                    $user->roles()->attach($registrationRole);
                }

                $user->notify(new VerifyUserNotification($user));
            }
        });
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public static function boot()
    {
        parent::boot();
        User::observe(new \App\Observers\UserActionObserver());
    }

    public function userAnswers()
    {
        return $this->hasMany(Answer::class, 'user_id', 'id');
    }

    public function userVotes()
    {
        return $this->hasMany(Vote::class, 'user_id', 'id');
    }

    public function userComments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function followerFollows()
    {
        return $this->hasMany(Follow::class, 'follower_id', 'id');
    }

    public function followingFollows()
    {
        return $this->hasMany(Follow::class, 'following_id', 'id');
    }

    public function userAnimals()
    {
        return $this->hasMany(Animal::class, 'user_id', 'id');
    }

    public function userPosts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function userUserAddresses()
    {
        return $this->hasMany(UserAddress::class, 'user_id', 'id');
    }

    public function userLikes()
    {
        return $this->hasMany(Like::class, 'user_id', 'id');
    }

    public function userDislikes()
    {
        return $this->hasMany(Dislike::class, 'user_id', 'id');
    }

    public function userViews()
    {
        return $this->hasMany(View::class, 'user_id', 'id');
    }

    public function userUserAlerts()
    {
        return $this->belongsToMany(UserAlert::class);
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function getVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setVerifiedAtAttribute($value)
    {
        $this->attributes['verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
