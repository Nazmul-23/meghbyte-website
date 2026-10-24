<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    public const CATEGORIES = ['web' => 'Websites', 'app' => 'Mobile apps', 'system' => 'Management systems'];

    public const STATUSES = ['live' => 'Live', 'in_development' => 'In development'];

    protected $fillable = [
        'title', 'slug', 'client_type', 'category', 'status', 'summary', 'problem', 'solution',
        'results', 'features', 'tech_stack', 'url', 'is_featured', 'is_published', 'sort_order',
        'meta_title', 'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'tech_stack' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('is_published', true)->orderBy('sort_order')->orderBy('id');
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst((string) $this->status);
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst((string) $this->category);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
