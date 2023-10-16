<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('
            CREATE PROCEDURE InsertIntoDues()
            BEGIN
                DECLARE activeYearId INT;
                SELECT id INTO activeYearId FROM active_years WHERE active = 1;

                INSERT INTO dues (name, total_amount, type, `group`, active_year_id)
                SELECT a.name, a.total_amount, a.type, a.`group`, activeYearId
                FROM dues a
                WHERE a.active_year_id = activeYearId - 1 AND NOT EXISTS (
                    SELECT 1
                    FROM dues b
                    WHERE b.active_year_id = activeYearId AND b.name = a.name
                );
            END
        ');
    }



    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS InsertIntoDues');
    }
};
