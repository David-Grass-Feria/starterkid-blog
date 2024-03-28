<?php

namespace GrassFeria\StarterkidBlog\Models;

use App\Models\User;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Enums\CropPosition;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BlogPost extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'name',
        'title',
        'preview',
        'content',
        'created_at',
        'status',
        'slug',
        'author',
        'image_credits',
    ];


    protected $casts = [

        
        'status' => 'boolean',

    ];

    public function scopeOfUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

     public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPublished()
    {
        return $this->created_at->format(config('starterkid.time_format.date_time_format'));
    }
    
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),

        );
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($model) {
            $url = route('front.blog-post.show', ['slug' => $model->slug]);
            $cacheKey = \GrassFeria\StarterkidFrontend\Services\GetCacheKey::ForUrl($url);
            \Illuminate\Support\Facades\Cache::forget($cacheKey);
            $cacheKeyHomepage = \GrassFeria\StarterkidFrontend\Services\GetCacheKey::ForUrl(route('front.homepage'));
            \Illuminate\Support\Facades\Cache::forget($cacheKeyHomepage);
          
           
        });
        static::deleted(function ($model) {
            $url = route('front.blog-post.show', ['slug' => $model->slug]);
            $cacheKey = \GrassFeria\StarterkidFrontend\Services\GetCacheKey::ForUrl($url);
            \Illuminate\Support\Facades\Cache::forget($cacheKey);
            $cacheKeyHomepage = \GrassFeria\StarterkidFrontend\Services\GetCacheKey::ForUrl(route('front.homepage'));
            \Illuminate\Support\Facades\Cache::forget($cacheKeyHomepage);
           
       
         });
    }

    public function scopeFrontGetBlogPostWhereStatusIsOnline(\Illuminate\Database\Eloquent\Builder $query, $search = '', $orderBy = 'created_at', $sort = 'desc'): \Illuminate\Database\Eloquent\Builder
    {
        $query = $query->select('id', 'name', 'title', 'created_at', 'status', 'slug', 'preview','author','image_credits')
            ->with('media')
            ->where('status', true);

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('title', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%');
            });
        }

        $query->orderBy($orderBy, $sort);

        return $query;
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(200);
        $this->addMediaConversion('medium')
              ->width(300);
       $this->addMediaConversion('large')
              ->width(1200);
        
              
              
    }
}