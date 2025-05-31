<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class RepairRequest extends Model
{
    use HasFactory, AsSource, Filterable, Attachable;

    protected $guarded = [];

    protected $casts = [
        'repair_start_date' => 'datetime',
        'repair_end_date' => 'datetime',
    ];

    // Связь с моделью Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Связь с моделью Part
    public function part()
    {
        return $this->belongsTo(Part::class);
    }

    // Связь с моделью Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Событие при создании заявки
    protected static function booted()
    {
        static::created(function ($repairRequest) {
            // Вызываем метод для уменьшения количества запчастей
            $repairRequest->decreasePartQuantity();
        });
    }

    // Метод для уменьшения количества запчастей
    public function decreasePartQuantity()
    {
        $part = $this->part;

        // Проверяем, если запчасть существует и ее количество больше 0
        if ($part && $part->quantity > 0) {
            // Уменьшаем количество запчастей на 1
            $part->quantity -= 1;
            $part->save();
        }
    }
}
