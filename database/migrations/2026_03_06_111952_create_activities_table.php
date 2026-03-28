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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();//id กิจกรรม
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // id คนสร้าง กิจกรรมหายถ้าคนสร้างโดนลบ

            $table->string('title');
            $table->text('description');
            $table->date('date');
            $table->string('location');
            $table->date('registration_deadline');
            $table->string('image')->nullable();
            
            $table->integer('max_participants')->default(0); // รับกี่คน? (0 = ไม่จำกัด)
            $table->string('status')->default('pending');   // สถานะ (pending/approved)

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
