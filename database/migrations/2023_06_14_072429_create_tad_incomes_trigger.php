<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $trigger = "
            CREATE TRIGGER tad_incomes
            AFTER DELETE ON incomes
            FOR EACH ROW
            BEGIN
                DELETE FROM journal WHERE OLD.`trn` = `trn`;
            END
        ";

        DB::unprepared($trigger);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $trigger = "DROP TRIGGER IF EXISTS tad_incomes";
        DB::unprepared($trigger);
    }
};
