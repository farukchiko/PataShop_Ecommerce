<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ShippingAddress extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    protected $fillable = [
        'user_id',
        'recipient_name',
        'phone',
        'full_address',
        'city',
        'postal_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
