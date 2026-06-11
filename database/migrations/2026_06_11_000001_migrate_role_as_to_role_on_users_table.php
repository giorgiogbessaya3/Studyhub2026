<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('eleve')->after('password');
            });
        }

        if (Schema::hasColumn('users', 'role_as')) {
            DB::table('users')->where('role_as', 1)->update(['role' => 'admin']);
            DB::table('users')->where('role_as', 0)->update(['role' => 'eleve']);

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role_as');
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('role_as')->default(0);
        });

        DB::table('users')->where('role', 'admin')->update(['role_as' => 1]);
        DB::table('users')->whereIn('role', ['enseignant', 'eleve'])->update(['role_as' => 0]);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
