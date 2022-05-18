<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactEmails extends Model
{
    use HasFactory;
    protected $table = 'contact_emails';
    protected $fillable = ['contact_id', 'email'];
}
