<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourtBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'court_id',
        'user_id',
        'booking_date',
        'start_time',
        'end_time',
        'price',
        'status',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'price' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }
}