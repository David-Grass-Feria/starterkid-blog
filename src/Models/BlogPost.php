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

        // stop if cache is false
        if(config('starterkid-frontend.frontend_cache') == false){
            return;
        }

        static::updated(function ($model) {
            $url = route('front.blog-post.show', ['slug' => $model->slug]);
            $cacheKey = \GrassFeria\StarterkidFrontend\Services\GetCacheKey::ForUrl($url);
            \Illuminate\Support\Facades\Cache::forget($cacheKey);
            \GrassFeria\StarterkidFrontend\Jobs\PreloadCacheJob::dispatch($url);

            
            $cacheKeyHomepage = \GrassFeria\StarterkidFrontend\Services\GetCacheKey::ForUrl(route('front.homepage'));
            \Illuminate\Support\Facades\Cache::forget($cacheKeyHomepage);
            \GrassFeria\StarterkidFrontend\Jobs\PreloadCacheJob::dispatch(route('front.homepage'));
           
        });

       
        static::deleted(function ($model) {
            $url = route('front.blog-post.show', ['slug' => $model->slug]);
            $cacheKey = \GrassFeria\StarterkidFrontend\Services\GetCacheKey::ForUrl($url);
            \Illuminate\Support\Facades\Cache::forget($cacheKey);
            \GrassFeria\StarterkidFrontend\Jobs\PreloadCacheJob::dispatch($url);

            
            $cacheKeyHomepage = \GrassFeria\StarterkidFrontend\Services\GetCacheKey::ForUrl(route('front.homepage'));
            \Illuminate\Support\Facades\Cache::forget($cacheKeyHomepage);
            \GrassFeria\StarterkidFrontend\Jobs\PreloadCacheJob::dispatch(route('front.homepage'));
           
       
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
              ->width(config('starterkid.image_conversions.thumb.width'))
              ->sharpen(config('starterkid.image_conversions.thumb.sharpen'))
              ->quality(config('starterkid.image_conversions.thumb.quality'))
              ->format('webp');
        $this->addMediaConversion('medium')
              ->width(config('starterkid.image_conversions.medium.width'))
              ->sharpen(config('starterkid.image_conversions.medium.sharpen'))
              ->quality(config('starterkid.image_conversions.medium.quality'))
              ->format('webp');
       $this->addMediaConversion('large')
              ->width(config('starterkid.image_conversions.large.width'))
              ->sharpen(config('starterkid.image_conversions.large.sharpen'))
              ->quality(config('starterkid.image_conversions.large.quality'))
              ->format('webp');
              
        
            
              
              
    }
}