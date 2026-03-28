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
        // 1. ตารางเก็บชื่อ Tag
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // เช่น กีฬา, วิชาการ
            $table->timestamps();
        });

        // 2. ตาราง Pivot สำหรับเชื่อม กิจกรรม <-> Tag (Many-to-Many)
        Schema::create('activity_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained()->cascadeOnDelete(); //
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete(); //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags_and_activity_tag_tables');
    }
};
