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
            CREATE PROCEDURE UpdateStudents()
            BEGIN
                DECLARE activeYearId INT;
                SELECT id INTO activeYearId FROM active_years WHERE active = 1;

                UPDATE students
                SET `group` = "LL", active_year_id = activeYearId
                WHERE `group` = "06" AND `group` != "LL";

                UPDATE students
                SET `group` = "TF", active_year_id = activeYearId
                WHERE `temp_status` = "TF" AND `group` != "TF";

                UPDATE students
                SET `group` = "DO", active_year_id = activeYearId
                WHERE `temp_status` = "DO" AND `group` != "DO";

                UPDATE students
                SET `group` = CONCAT("0", `group` + 1), active_year_id = activeYearId
                WHERE `group` NOT IN ("LL", "TF", "DO") AND `temp_status` = "NK";

                UPDATE students
                SET active_year_id = activeYearId
                WHERE `temp_status` IN ("TK");

                UPDATE students
                SET `temp_status` = "NK"
                WHERE `group` NOT IN ("LL", "TF", "DO");

            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sql = "DROP PROCEDURE IF EXISTS UpdateStudents";
        DB::unprepared($sql);
    }
};
