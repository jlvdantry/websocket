<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatediff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          DB::statement(" 
CREATE OR REPLACE FUNCTION DateDiff (units VARCHAR(30), start_t timestamp, end_t timestamp)
     RETURNS numeric AS $$
   DECLARE
     diff time = null;
     total numeric(8)=0;
   BEGIN
     diff = end_t - start_t;
     total = (date_part('hour',diff)*60*60)+(date_part('minute',diff)*60)+date_part('second',diff);
     RETURN total;
   END;
   $$ LANGUAGE plpgsql;
          ");
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datediff');
    }
}
