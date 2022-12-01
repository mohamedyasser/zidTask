<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'price',
        'url',
        'description',
        'provider'
    ];

    public static function statistics(): array
    {
        return [
            'total' => self::count(),
            'average_price' => self::average('price'),
            'highest_total_price' => self::groupBy('provider')
                ->selectRaw('sum(price) as total, provider')->orderBy('total', 'desc')
                ->first()->toArray(),
            'total_price_month' => self::whereMonth('created_at', now()->month)
                ->selectRaw('sum(price) as total')->first()->total,
        ];
    }
}
