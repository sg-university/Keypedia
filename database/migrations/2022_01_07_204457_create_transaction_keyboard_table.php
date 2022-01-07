
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionKeyboardTable extends Migration
{
    /**
     * Run the migrations.
     CREATE TABLE `transaction_keyboard` (
  `id` decimal(19,0) NOT NULL,
  `transaction_id` decimal(19,0) NOT NULL,
  `keyboard_id` decimal(19,0) NOT NULL,
  `quantity` decimal(19,0) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FKtransactio153703` (`transaction_id`),
  KEY `FKtransactio876753` (`keyboard_id`),
  CONSTRAINT `FKtransactio153703` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`id`),
  CONSTRAINT `FKtransactio876753` FOREIGN KEY (`keyboard_id`) REFERENCES `keyboard` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_keyboard', function (Blueprint $table) {
            // ["id", "decimal(19,0)", "NO", "PRI", null, ""]
            $table->id();
            // ["transaction_id", "decimal(19,0)", "NO", "MUL", null, ""]
            $table->foreignId('transaction_id');
            $table->foreign('transaction_id', 'fk_transactionid_transactionkeyboard_transaction')->references('id')->on('transaction')->onUpdate('cascade')->onDelete('cascade');

            // ["keyboard_id", "decimal(19,0)", "NO", "MUL", null, ""]
            $table->foreignId('keyboard_id');
            $table->foreign('keyboard_id', 'fk_keyboardid_transactionkeyboard_keyboard')->references('id')->on('keyboard')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('transaction_keyboard');
    }
}
?>
