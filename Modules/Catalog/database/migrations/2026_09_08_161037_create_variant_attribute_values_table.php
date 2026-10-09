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
        Schema::create('variant_attribute_values', function (Blueprint $table) {
            $table->foreignId('product_variant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_attribute_value_id')->constrained('product_attribute_values', 'id', 'v_attr_val_foreign')->cascadeOnDelete();

            // مفتاح رئيسي مركب لمنع تكرار نفس القيمة على نفس الـ Variant ولتسريع الاستعلامات
            $table->primary(['product_variant_id', 'product_attribute_value_id'], 'variant_attr_val_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_attribute_values');
    }
};
