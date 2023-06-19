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
            CREATE TRIGGER tai_incomes
            AFTER INSERT ON incomes
            FOR EACH ROW
            BEGIN
                INSERT INTO journal (`trn`, `date`, `debit`, `credit`, `coa_id`) 
                VALUES (NEW.`trn`, NEW.`date`, NEW.`amount`, 0, NEW.`coa_id`);
            END
        ";

        DB::unprepared($trigger);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $trigger = "DROP TRIGGER IF EXISTS tai_incomes";
        DB::unprepared($trigger);
    }
};
