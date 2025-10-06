<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            // Hapus foreign key yang salah (ke albums)
            $table->dropForeign('comments_album_id_foreign');

            // Tambahkan foreign key yang benar (ke photos)
            $table->foreign('photo_id')->references('id')->on('photos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            // Hapus foreign key yang benar
            $table->dropForeign(['photo_id']);

            // Kembalikan foreign key yang salah (untuk rollback)
            $table->foreign('photo_id')->references('id')->on('albums')->onDelete('cascade');
        });
    }
};
