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
            CREATE PROCEDURE InsertIntoCoas()
            BEGIN
                DECLARE activeYearId INT;
                SELECT id INTO activeYearId FROM active_years WHERE active = 1;

                INSERT INTO coas (code, name, active_year_id, initial_balance)
                SELECT a.code, a.name, activeYearId, 0
                FROM coas a
                WHERE a.active_year_id = activeYearId - 1
                AND NOT EXISTS (
                    SELECT 1
                    FROM coas b
                    WHERE b.code = a.code
                    AND b.name = a.name
                    AND b.active_year_id = activeYearId
                );
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS InsertIntoCoas');
    }
};
