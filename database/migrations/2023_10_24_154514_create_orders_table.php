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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\User::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('status')->default('формируется');
            $table->text('comment')->nullable();
            $table->foreignIdFor(App\Models\Filial::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->float('sum')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
