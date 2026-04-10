<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("costums", function (Blueprint $table) {
            $table->id();
            $table->string("photo_url")->nullable();
            $table->string("name");
            $table->string("name_anime");
            $table->string("size")->nullable();
            $table->integer("stock")->default(0);
            $table->decimal("priceday", 12, 2)->default(0);
            $table->text("desc")->nullable();
            $table
                ->foreignId("source_anime_category_id")
                ->constrained("categories")
                ->cascadeOnDelete();
            $table
                ->foreignId("brand_costum_category_id")
                ->constrained("categories")
                ->cascadeOnDelete();
            $table->enum("paxel", ["small", "medium", "large", "custom"]);
            $table->decimal("berat_jnt", 8, 2);
            $table->string("lokasi")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("costums");
    }
};
