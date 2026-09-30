<?php

use App\Models\SchoolYear;
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
        Schema::create('school_years', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('desc');
            $table->timestamps();
            $table->softDeletes();
        });

        $school_years = [
            ['name' => '2018 - 2019', 'desc' => 'S.Y. 2018 - 2019'],
            ['name' => '2019 - 2020', 'desc' => 'S.Y. 2019 - 2020'],
            ['name' => '2020 - 2021', 'desc' => 'S.Y. 2020 - 2021'],
            ['name' => '2021 - 2022', 'desc' => 'S.Y. 2021 - 2022'],
            ['name' => '2022 - 2023', 'desc' => 'S.Y. 2022 - 2023'],
            ['name' => '2023 - 2024', 'desc' => 'S.Y. 2023 - 2024'],
            ['name' => '2024 - 2025', 'desc' => 'S.Y. 2024 - 2025'],
            ['name' => '2025 - 2026', 'desc' => 'S.Y. 2025 - 2026'],
            ['name' => '2026 - 2027', 'desc' => 'S.Y. 2026 - 2027'],
        ];

        foreach ($school_years as $school_year) {
            SchoolYear::create($school_year);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_years');
    }
};
