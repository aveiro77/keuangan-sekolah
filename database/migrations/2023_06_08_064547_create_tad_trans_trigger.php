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
            CREATE TRIGGER tad_trans
            AFTER DELETE ON transactions
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
        $trigger = "DROP TRIGGER IF EXISTS tad_trans";
        DB::unprepared($trigger);
    }
};
