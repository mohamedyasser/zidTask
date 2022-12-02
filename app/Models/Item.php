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

    public static function statistics(string $type): array
    {
        $statistics = [];
        switch ($type) {
            case 'total':
                $statistics['total'] = self::count();
                break;
            case 'average':
                $statistics['average'] = self::average('price');
                break;
            case 'highest':
                $statistics['highest'] = self::groupBy('provider')
                    ->selectRaw('sum(price) as total, provider')->orderBy('total', 'desc')
                    ->first()->toArray();
                break;
            case 'monthly':
                $statistics['month'] = self::whereMonth('created_at', now()->month)
                    ->selectRaw('sum(price) as total')->first()->total;
                break;
            default:
                $statistics = [
                    'total' => self::count(),
                    'average' => self::average('price'),
                    'highest' => self::groupBy('provider')
                        ->selectRaw('sum(price) as total, provider')->orderBy('total', 'desc')
                        ->first()->toArray(),
                    'monthly' => self::whereMonth('created_at', now()->month)
                        ->selectRaw('sum(price) as total')->first()->total,
                ];
        }

        return $statistics;
    }
}
