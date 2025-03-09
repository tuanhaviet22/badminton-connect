<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Court extends Model
{
    use HasFactory;

    protected $table = 'badminton_courts';

    protected $fillable = [
        'name',
        'branch_id',
        'price_per_hour',
        'use_branch_price',
    ];

    protected $casts = [
        'facilities' => 'array',
    ];

    const STATUS_OPEN = 1;
    const STATUS_CLOSED = 2;

    public static array $statusLabels = [
        self::STATUS_OPEN => 'Open',
        self::STATUS_CLOSED => 'Close',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    // Automatically set price from branch if "use_branch_price" is true
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($court) {
            if ($court->use_branch_price) {
                $court->price_per_hour = $court->branch->price_per_hour;
            }
        });

        static::created(function ($court) {
            $court->branch->increment('number_of_courts');
        });
    }
}
