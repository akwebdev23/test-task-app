<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Factories\FactoryInterface;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'message',
    ];

}
