
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartKeyboardTable extends Migration
{
    /**
     * Run the migrations.
     CREATE TABLE `cart_keyboard` (
  `id` decimal(19,0) NOT NULL,
  `cart_id` decimal(19,0) NOT NULL,
  `keyboard_id` decimal(19,0) NOT NULL,
  `quantity` decimal(19,0) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FKcart_keybo959609` (`cart_id`),
  KEY `FKcart_keybo87104` (`keyboard_id`),
  CONSTRAINT `FKcart_keybo87104` FOREIGN KEY (`keyboard_id`) REFERENCES `keyboard` (`id`),
  CONSTRAINT `FKcart_keybo959609` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
     * @return void
     */
    public function up()
    {
        Schema::create('cart_keyboard', function (Blueprint $table) {
            // ["id", "decimal(19,0)", "NO", "PRI", null, ""]
            $table->id();
            // ["cart_id", "decimal(19,0)", "NO", "MUL", null, ""]
            $table->foreignId('cart_id');
            $table->foreign('cart_id', 'fk_cartid_cartkeyboard_cart')->references('id')->on('cart')->onUpdate('cascade')->onDelete('cascade');
            // ["keyboard_id", "decimal(19,0)", "NO", "MUL", null, ""]
            $table->foreignId('keyboard_id');
            $table->foreign('keyboard_id', 'fk_keyboardid_cartkeyboard_keyboard')->references('id')->on('keyboard')->onUpdate('cascade')->onDelete('cascade');
            // ["quantity", "decimal(19,0)", "YES", "", null, ""]
            $table->decimal('quantity', 19, 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_keyboard');
    }
}
?>
