<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_id')
                ->constrained('jobs_news')
                ->cascadeOnDelete();

            $table->foreignId('user_id') // freelancer
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('cv_file'); // path file CV

            $table->timestamps();

            // supaya 1 user hanya bisa apply 1x ke 1 job
            $table->unique(['job_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
