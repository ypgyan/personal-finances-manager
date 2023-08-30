<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::connection('mongodb')->create('expenses', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('account_id');
            $table->index('category_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('expenses');
    }
};
