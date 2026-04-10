<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("categories", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("desc")->nullable();
            $table->enum("type", [
                "pemasukan",
                "pengeluaran",
                "maintenance",
                "source_anime",
                "brand",
            ]);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("categories");
    }
};
