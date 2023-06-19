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
            CREATE TRIGGER tai_trans
            AFTER INSERT ON transactions
            FOR EACH ROW
            BEGIN
                INSERT INTO journal (`trn`, `date`, `debit`, `credit`, `coa_id`, `coa_id2`, `partner_id`, `student_id`, `due_id`) 
                VALUES (NEW.`trn`, NEW.`date`, 0, NEW.`grand_total`, NEW.`coa_id`, null, NEW.`partner_id`, null, null);
            END
        ";

        DB::unprepared($trigger);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $trigger = "DROP TRIGGER IF EXISTS tai_trans";
        DB::unprepared($trigger);
    }
};
