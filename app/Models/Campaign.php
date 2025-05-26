<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = ['name', 'description'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
