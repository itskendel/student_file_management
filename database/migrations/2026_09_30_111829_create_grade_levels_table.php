<?php

use App\Models\GradeLevel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grade_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('desc');
            $table->timestamps();
            $table->softDeletes();
        });

        $grade_levels = [
            ['name' => '11', 'desc' => 'SHS Grade 11'],
            ['name' => '12', 'desc' => 'SHS Grade 12'],
        ];

        foreach ($grade_levels as $level) {
            GradeLevel::create($level);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_levels');
    }
};
