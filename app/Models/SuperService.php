<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperService extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'type', 'description'];
}
