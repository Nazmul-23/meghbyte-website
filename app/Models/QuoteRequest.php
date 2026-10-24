<?php

namespace App\Models;

use App\Enums\LeadStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuoteRequest extends Model
{
    use SoftDeletes;

    public const BUDGETS = [
        'under_1k' => 'Less than $1K',
        '1k_3k' => '$1K – $3K',
        '3k_10k' => '$3K – $10K',
        '10k_plus' => 'More than $10K',
        'not_sure' => 'Not sure yet',
        // Older keys kept so existing leads still show a readable label.
        'under_20k' => 'Below ৳20,000',
        '20k_50k' => '৳20,000 – ৳50,000',
        '50k_plus' => '৳50,000+',
        'usd' => 'USD project (international)',
    ];

    /** Options shown on the public form. */
    public const PUBLIC_BUDGETS = ['under_1k', '1k_3k', '3k_10k', '10k_plus', 'not_sure'];

    /** status, notes and request metadata are set by the app, not by the public form. */
    protected $fillable = ['name', 'phone', 'email', 'business_name', 'service_id', 'budget', 'message'];

    protected function casts(): array
    {
        return [
            'status' => LeadStatus::class,
            'contacted_at' => 'datetime',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class)->withTrashed();
    }

    public function budgetLabel(): ?string
    {
        return $this->budget ? (self::BUDGETS[$this->budget] ?? $this->budget) : null;
    }

    public function whatsappUrl(): string
    {
        $number = ltrim($this->phone, '+');
        $text = "Assalamu alaikum {$this->name}, Meghbyte theke bolchi. Apnar quote request peyechi, dhonnobad!";

        return 'https://wa.me/'.$number.'?text='.rawurlencode($text);
    }
}
