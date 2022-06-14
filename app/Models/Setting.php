<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'logo',
        'header_text',
        'phone_number',
        'footer_description',
        'map',
        'email',
        'newsletter_header',
        'newsletter_text',
        'address',
    

    ];
}
