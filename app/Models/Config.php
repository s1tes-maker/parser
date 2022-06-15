<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;
    protected $connection = "mysql2";
    protected $table = "configs";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'count', 'profile', 'suggest_price', 'suggest_price_message', 'discount_min', 'discount_max'
    ];
}
