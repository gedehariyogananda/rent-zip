<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("maintenances", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("costum_id")
                ->constrained("costums")
                ->cascadeOnDelete();
            $table->integer("current_stock")->nullable();
            $table
                ->foreignId("category_id")
                ->nullable()
                ->constrained("categories")
                ->nullOnDelete();
            $table->enum("type", ["penambahan", "pengurangan"]);
            $table->integer("pcs")->default(1);
            $table->text("desc")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("maintenances");
    }
};
