<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentialAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'postcode',
        'address',
        'building',
    ];

    public function getFormattedPostalCode()
    {
        return '〒' . substr($this->postcode, 0, 3) . '-' . substr($this->postcode, 3);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
