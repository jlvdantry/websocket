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
     diff timestamp(0) = null;
     total numeric(8)=0;
   BEGIN
SELECT ((DATE_PART('day', end_t - start_t) * 24 +
                DATE_PART('hour', end_t - start_t)) * 60 +
                DATE_PART('minute', end_t - start_t)) * 60 +
                DATE_PART('second', end_t - start_t) into total;
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
