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
            CREATE TRIGGER tau_incomes
            AFTER UPDATE ON incomes
            FOR EACH ROW
            BEGIN
                UPDATE journal SET
                  `date` = NEW.`date`,
                  `debit` = NEW.`amount`,
                  `coa_id` = NEW.`coa_id`
                WHERE `trn` = NEW.`trn`;
            END
        ";

        DB::unprepared($trigger);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $trigger = "DROP TRIGGER IF EXISTS tau_incomes";
        DB::unprepared($trigger);
    }
};
