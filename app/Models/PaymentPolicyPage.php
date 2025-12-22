<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentPolicyPage extends Page
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // Ensure all queries are scoped to the 'payment-policy' page.
        static::addGlobalScope('payment_policy', function ($builder) {
            $builder->where('slug', 'payment-policy');
        });

        // Automatically set the slug when creating a new instance.
        static::creating(function ($page) {
            $page->slug = 'payment-policy';
        });
    }

    // Accessors & Mutators for the 'content' JSON field

    protected function mainContent(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => json_decode($attributes['content'] ?? 'null', true)['main_content'] ?? null,
            set: fn ($value) => $this->setContent('main_content', $value),
        );
    }

    protected function policyItems(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => json_decode($attributes['content'] ?? '[]', true)['policy_items'] ?? [],
            set: fn ($value) => $this->setContent('policy_items', $value),
        );
    }

    /**
     * Helper function to set a value in the content JSON field.
     */
    private function setContent(string $key, $value): void
    {
        $content = $this->content ?? [];
        $content[$key] = $value;
        $this->content = $content;
    }
}
