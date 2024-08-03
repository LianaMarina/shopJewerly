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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('images')->nullable();
            $table->float('price');
            $table->foreignIdFor(App\Models\Material::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(App\Models\Sample::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(App\Models\Stone::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(App\Models\Cutting::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(App\Models\Whome::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(App\Models\Type::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(App\Models\Subtype::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(App\Models\Brand::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
