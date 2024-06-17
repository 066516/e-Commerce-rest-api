<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shipping', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id'); // Link to the order
            $table->string('status')->default('pending'); // e.g., pending, shipped, delivered
            $table->string('carrier')->nullable();  // FedEx, DHL, etc.
            $table->string('tracking_number')->nullable();
            $table->text('address')->nullable(); // Destination address
            $table->decimal('shipping_cost', 8, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade'); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipping');
    }
};
