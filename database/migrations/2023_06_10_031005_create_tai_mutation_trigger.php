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
            CREATE TRIGGER tai_mutations
            AFTER INSERT ON mutations
            FOR EACH ROW
            BEGIN
                INSERT INTO journal (`trn`, `date`, `debit`, `credit`, `coa_id`, `coa_id2`, `partner_id`, `student_id`, `due_id`, `stack`) 
                VALUES (NEW.`trn`, NEW.`date`, NEW.`debit`, NEW.`credit`, NEW.`coa_id`, NEW.`coa_id2`, null, null, null, NEW.`stack`);
            END
        ";

        DB::unprepared($trigger);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $trigger = "DROP TRIGGER IF EXISTS tai_mutations";
        DB::unprepared($trigger);
    }
};
