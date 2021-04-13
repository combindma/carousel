<?php

namespace Combindma\Carousel\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Carousel extends Model implements HasMedia
{
    use HasFactory;
    use Sluggable;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'description',
        'published_at',
        'is_published',
        'is_featured',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'published_at' => 'datetime',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    protected static function newFactory()
    {
        return \Combindma\Carousel\Database\Factories\CarouselFactory::new();
    }

    public static function getAllCarousels()
    {
        return Cache::rememberForever('carousels', function () {
            return self::published()
                ->orderBy('published_at', 'desc')
                ->orderBy('id', 'desc')
                ->with(['media'])
                ->get(['id', 'title', 'slug', 'description', 'content', 'published_at', 'is_published', 'meta']);
        });
    }

    public static function getFeaturedCarousels()
    {
        return Cache::rememberForever('featuredCarousels', function () {
            return self::published()
                ->featured()
                ->orderBy('published_at', 'desc')
                ->orderBy('id', 'desc')
                ->with(['media'])
                ->get(['id', 'title', 'slug', 'description', 'content', 'published_at', 'is_published', 'meta']);
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1);
    }

    public function getDatePublicationAttribute()
    {
        return $this->published_at->ago();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')
            ->withResponsiveImages()
            ->singleFile()
            ->acceptsFile(function (File $file) {
                return ($file->mimeType === 'image/jpeg') or ($file->mimeType === 'image/jpg') or ($file->mimeType === 'image/png');
            });

        $this->addMediaCollection('images')
            ->withResponsiveImages()
            ->acceptsFile(function (File $file) {
                return ($file->mimeType === 'image/jpeg') or ($file->mimeType === 'image/jpg') or ($file->mimeType === 'image/png');
            });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->performOnCollections('featured_image')
            ->nonQueued();

        $this->addMediaConversion('thumb')
            ->width(200)
            ->performOnCollections('images')
            ->nonQueued();

        $this->addMediaConversion('preview')
            ->width(1000)
            ->performOnCollections('featured_image')
            ->nonQueued();
    }

    public function addFeaturedImage($file)
    {
        $this->addMedia($file)->toMediaCollection('featured_image', 'images');

        return $this;
    }

    public function addImage($file)
    {
        $this->addMedia($file)->toMediaCollection('images', 'images');

        return $this;
    }

    public function thumb_url()
    {
        return $this->getFirstMediaUrl('featured_image', 'thumb');
    }

    public function preview_url()
    {
        return $this->getFirstMediaUrl('featured_image', 'preview');
    }

    public function featured_image()
    {
        return $this->getFirstMedia('featured_image');
    }

    public function featured_image_url()
    {
        return $this->getFirstMediaUrl('featured_image');
    }

    public function images()
    {
        return $this->getMedia('images');
    }
}
