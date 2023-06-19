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
            CREATE TRIGGER tai_spp_trans
            AFTER INSERT ON spp_transactions
            FOR EACH ROW
            BEGIN
                INSERT INTO journal (`trn`, `date`, `debit`, `credit`, `coa_id`, `coa_id2`, `partner_id`, `student_id`, `due_id`) 
                VALUES (NEW.`trn`, NEW.`date`, NEW.`amount`, 0, NEW.`coa_id`, null, null, NEW.`student_id`, NEW.`due_id`);
            END
        ";

        DB::unprepared($trigger);
    }

    public function down(): void
    {
        $trigger = "DROP TRIGGER IF EXISTS tai_spp_trans";
        DB::unprepared($trigger);
    }
};
