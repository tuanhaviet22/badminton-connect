<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $table = "branches";

    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'latitude',
        'longitude',
        'amenities',
        'opening_hours',
        'price_per_hour',
        'manager_id',
        'number_of_courts',
        'stadium_map',
        'images',
    ];

    protected $casts = [
        'amenities' => 'array',
        'opening_hours' => 'array',
        'images' => 'array',
    ];

    protected $spatialFields = ['location'];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function courts()
    {
        return $this->hasMany(Court::class, 'branch_id');
    }


    public static function boot()
    {

        parent::boot();

        static::saved(function ($branch) {
            $existingCourts = $branch->courts()->count();
            // If the number of courts is increased, auto-generate missing courts
            if ($branch->number_of_courts > $existingCourts) {
                for ($i = $existingCourts + 1; $i <= $branch->number_of_courts; $i++) {
                    Court::create([
                        'name' => 'Court ' . $i,
                        'branch_id' => $branch->id,
                    ]);
                }
            }
        });
    }
}

