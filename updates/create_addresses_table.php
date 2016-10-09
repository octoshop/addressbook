<?php namespace Octoshop\AddressBook\Updates;

use Schema;
use Octoshop\Core\Updates\Migration;
use October\Rain\Database\Schema\Blueprint;

class CreateAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('octoshop_addresses', function(Blueprint$table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->default(0);
            $table->string('alias')->default('');
            $table->string('first_name')->default('');
            $table->string('last_name')->default('');
            $table->string('company')->default('');
            $table->string('line1')->default('');
            $table->string('line2')->default('');
            $table->string('town')->default('');
            $table->string('region')->default('');
            $table->string('postcode')->default('');
            $table->string('country')->default('');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('octoshop_addresses');
    }
}
