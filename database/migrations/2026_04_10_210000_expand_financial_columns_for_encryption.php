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
        Schema::table('expenses', function (Blueprint $table) {
            $table->text('product_name')->change();
            $table->text('price')->change();
        });

        Schema::table('incomes', function (Blueprint $table) {
            $table->text('source_name')->change();
            $table->text('amount')->change();
        });

        Schema::table('budgets', function (Blueprint $table) {
            $table->text('amount')->change();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->text('name')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->string('product_name')->change();
            $table->decimal('price', 10, 2)->change();
        });

        Schema::table('incomes', function (Blueprint $table) {
            $table->string('source_name')->change();
            $table->decimal('amount', 10, 2)->change();
        });

        Schema::table('budgets', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)->change();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('name')->change();
        });
    }
};
