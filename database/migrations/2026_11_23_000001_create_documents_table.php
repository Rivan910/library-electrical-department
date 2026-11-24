<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sheet_row_number')->nullable()->unique();
            $table->string('no', 50)->nullable();
            $table->string('document_no')->index();
            $table->string('vendor')->nullable()->index();
            $table->text('title')->nullable();
            $table->string('content')->nullable()->index();
            $table->string('rack', 100)->nullable()->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
