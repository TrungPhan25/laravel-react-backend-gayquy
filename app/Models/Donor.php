<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;
    protected $table='donors';
    protected $fillable=[
        'name',
        'email',
        'frequency',
        'number_money',
        'status',
    ];
}
