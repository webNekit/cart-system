<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Product extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function typeProduct()
    {
        return $this->belongsTo(TypeProduct::class);
    }

    public function parts()
    {
        return $this->hasMany(Part::class);
    }
}
