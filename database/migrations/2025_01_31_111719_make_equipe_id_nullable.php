<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('attestations', function (Blueprint $table) {
            $table->unsignedBigInteger('equipe_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('attestations', function (Blueprint $table) {
            $table->unsignedBigInteger('equipe_id')->nullable(false)->change(); // إعادة الحقل كما كان
        });
    }
};
