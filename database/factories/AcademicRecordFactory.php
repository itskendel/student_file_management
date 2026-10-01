<?php

namespace Database\Factories;

use App\Models\AcademicRecord;
use App\Models\GradeLevel;
use App\Models\SchoolYear;
use App\Models\Strand;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AcademicRecord>
 */
class AcademicRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $school_year = SchoolYear::inRandomOrder()->first();
        $grade_level = GradeLevel::inRandomOrder()->first();
        $strand = Strand::inRandomOrder()->first();

        return [
            'student_id' => Student::factory(),

            'school_year_id' => $school_year->id,
            'grade_level_id' => $grade_level->id,
            'strand_id' => $strand->id,

            'section' => $strand->name.'-'.$grade_level->name.fake()->randomElement(['A', 'B', 'C']),
        ];
    }

    /**
     * Assign the record to an existing school year.
     */
    public function schoolYear(SchoolYear $school_year): static
    {
        return $this->state(fn (array $attributes) => [
            'school_year_id' => $school_year->id,
        ]);
    }

    /**
     * Assign the record to an existing grade level.
     */
    public function gradeLevel(GradeLevel $grade_level): static
    {
        return $this->state(fn (array $attributes) => [
            'grade_level_id' => $grade_level->id,
        ]);
    }

    /**
     * Assign the record to an existing strand.
     */
    public function strand(Strand $strand): static
    {
        return $this->state(fn (array $attributes) => [
            'strand_id' => $strand->id,
        ]);
    }
}
