<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPhones extends Model
{
    use HasFactory;
    protected $table = 'contact_phones';
    protected $fillable = ['contact_id', 'phone'];
}
