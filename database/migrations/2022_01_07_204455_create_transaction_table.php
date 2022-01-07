
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     CREATE TABLE `transaction` (
  `id` decimal(19,0) NOT NULL,
  `user_id` decimal(19,0) NOT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FKtransactio717920` (`user_id`),
  CONSTRAINT `FKtransactio717920` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            // ["id", "decimal(19,0)", "NO", "PRI", null, ""]
            $table->id();
            // ["user_id", "decimal(19,0)", "NO", "MUL", null, ""]
            $table->foreignId('user_id');
            $table->foreign('user_id', 'fk_userid_transaction_user')->references('id')->on('user')->onUpdate('cascade')->onDelete('cascade');
            // ["timestamp", "timestamp", "YES", "", null, ""]
            $table->timestamp('timestamp')->nullable();
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
        Schema::dropIfExists('transaction');
    }
}
?>
