<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PricingPackage extends Model
{
    use SoftDeletes;

    public const GROUPS = ['websites' => 'Websites', 'apps' => 'Apps', 'systems' => 'Systems', 'care' => 'Care'];

    protected $fillable = [
        'name', 'slug', 'group', 'price', 'price_suffix', 'delivery', 'description', 'features',
        'is_highlighted', 'is_published', 'sort_order', 'service_id',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'features' => 'array',
            'is_highlighted' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('is_published', true)->orderBy('sort_order')->orderBy('id');
    }

    public function formattedPrice(): string
    {
        return '৳'.number_format($this->price);
    }
}
