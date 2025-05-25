<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('messages', function (Blueprint $table) {
        $table->id();

        // reference to a contact (the person receiving the message)
        $table->foreignId('contact_id')->constrained()->onDelete('cascade');

        // actual SMS content
        $table->text('body');

        // status of the message (queued, sent, delivered, failed)
        $table->string('status')->default('queued');

        // optional: Twilio SID so we can track status updates via webhook
        $table->string('twilio_sid')->nullable();

        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
