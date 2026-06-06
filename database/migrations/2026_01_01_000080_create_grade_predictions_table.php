<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Grade predictions calculated from each progress snapshot.
     * Unique progress_snapshot_id: one prediction per snapshot.
     * score_needed_for_a tells the student how many more marks they need
     * to reach an A. trajectory indicates whether they are improving, stable,
     * or declining. weeks_to_target estimates time to reach their goal.
     * CASCADE: if the snapshot is deleted, the prediction goes with it.
     */
    public function up(): void
    {
        Schema::create('grade_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('progress_snapshot_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('predicted_grade', 5);
            $table->decimal('confidence', 4, 3);
            $table->decimal('score_needed_for_a', 5, 2)->nullable();
            $table->string('trajectory', 20)->nullable(); // improving, stable, declining
            $table->unsignedTinyInteger('weeks_to_target')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_predictions');
    }
};
