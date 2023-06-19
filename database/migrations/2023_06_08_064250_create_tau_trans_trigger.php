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
            CREATE TRIGGER tau_trans
            AFTER UPDATE ON transactions
            FOR EACH ROW
            BEGIN
                UPDATE journal SET
                  `date` = NEW.`date`,
                  `credit` = NEW.`grand_total`,
                  `coa_id` = NEW.`coa_id`,
                  `partner_id` = NEW.`partner_id`
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
        $trigger = "DROP TRIGGER IF EXISTS tau_trans";
        DB::unprepared($trigger);
    }
};
