<?php

namespace App\Models;

use Database\Factories\HotelFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
    use HasFactory;

    public $table = 'hotel';

    protected $guarded = ['id'];

    public static $rules = [
        "product_name"  => "required",
        "vendor_name"   => "required",
        "sales"         => "required",
        "price"         => "required",
        "votes"         => "required",
    ];

    protected static function newFactory()
    {
        return HotelFactory::new();
    }
}
