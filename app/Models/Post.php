<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public const TYPE_SELECT = [
        '0' => 'Article',
        '1' => 'Question',
        '2' => 'Poll',
    ];

    public $table = 'posts';

    protected $appends = [
        'images',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'body',
        'slug',
        'like_count',
        'unlike_count',
        'view_count',
        'is_report',
        'answer_count',
        'type',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function boot()
    {
        parent::boot();
        Post::observe(new \App\Observers\PostActionObserver());
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function postReportsAbuses()
    {
        return $this->hasMany(ReportsAbuse::class, 'post_id', 'id');
    }

    public function postVotes()
    {
        return $this->hasMany(Vote::class, 'post_id', 'id');
    }

    public function postComments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function postLikes()
    {
        return $this->hasMany(Like::class, 'post_id', 'id');
    }

    public function postDislikes()
    {
        return $this->hasMany(Dislike::class, 'post_id', 'id');
    }

    public function postViews()
    {
        return $this->hasMany(View::class, 'post_id', 'id');
    }

    public function getImagesAttribute()
    {
        $files = $this->getMedia('images');
        $files->each(function ($item) {
            $item->url = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview = $item->getUrl('preview');
        });

        return $files;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
