<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // allow mass-assignment on these fields
    protected $fillable = ['phone_number', 'name'];

    // one contact can have many messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
