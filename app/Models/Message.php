<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // allow mass-assignment on these fields
    protected $fillable = ['contact_id', 'body', 'status', 'twilio_sid'];

    // a message belongs to a contact
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
