<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function up(): void
    {
        // Make sure you BACKUP your database before running migrations that alter primary keys.
        // This migration attempts to ensure the `id` column on `ec_shipments` is a
        // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY so Eloquent can insert rows.

        // Determine current max id to avoid AUTO_INCREMENT collision
        try {
            $max = DB::table('ec_shipments')->max('id');
            if (! $max) {
                $max = 0;
            }
        } catch (\Exception $e) {
            $max = 0;
        }

        // Check if the id column already has AUTO_INCREMENT
        try {
            $row = DB::selectOne("SELECT EXTRA FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'ec_shipments' AND COLUMN_NAME = 'id'");
            $extra = $row && isset($row->EXTRA) ? $row->EXTRA : '';
        } catch (\Exception $e) {
            $extra = '';
        }

        // If 'auto_increment' is not present, alter the column to add it.
        if (stripos($extra, 'auto_increment') === false) {
            // Modify column to be BIGINT UNSIGNED AUTO_INCREMENT. Do NOT re-declare PRIMARY KEY
            // if it already exists to avoid 'Multiple primary key defined' errors.
            DB::statement("ALTER TABLE `ec_shipments` MODIFY `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;");

            // Ensure next AUTO_INCREMENT is greater than current max id
            $next = $max + 1;
            DB::statement("ALTER TABLE `ec_shipments` AUTO_INCREMENT = {$next};");
        }
    }

    public function down(): void
    {
        // Reversing this change is potentially destructive if the original column
        // definition is unknown. We'll try to set id to BIGINT NOT NULL (no auto-inc)
        // so `down()` is a no-op in many cases. Consider restoring from a DB backup
        // if you must roll back this migration.
        try {
            DB::statement("ALTER TABLE `ec_shipments` MODIFY `id` BIGINT(20) UNSIGNED NOT NULL;");
        } catch (\Exception $e) {
            // ignore
        }
    }
};
