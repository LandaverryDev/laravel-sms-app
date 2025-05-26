<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // allow mass-assignment on these fields
    protected $fillable = ['contact_id', 'body', 'status', 'twilio_sid', 'campaign_id'];

    // a message belongs to a contact
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    // a message optionally belongs to a campaign
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
