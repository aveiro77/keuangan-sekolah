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
            CREATE TRIGGER tau_mutations
            AFTER UPDATE ON mutations
            FOR EACH ROW
            BEGIN
            
                UPDATE journal SET
                    `date` = NEW.`date`,
                    `coa_id` = NEW.`coa_id`,
                    `coa_id2` = NEW.`coa_id2`,
                    `credit` = NEW.`credit`
                WHERE `stack` = 1 AND `trn` = NEW.`trn`;
                
                UPDATE journal SET
                    `date` = NEW.`date`,
                    `coa_id` = NEW.`coa_id2`,
                    `coa_id2` = NEW.`coa_id`,
                    `debit` = NEW.`credit`
                WHERE `stack` = 2 AND `trn` = NEW.`trn`;
            
            END;
        
        ";

        DB::unprepared($trigger);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $trigger = "DROP TRIGGER IF EXISTS tau_mutations";
        DB::unprepared($trigger);
    }
};
