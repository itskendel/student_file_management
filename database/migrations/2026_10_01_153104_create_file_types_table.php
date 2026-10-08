<?php

use App\Models\FileType;
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
        Schema::create('file_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('desc');
            $table->timestamps();
            $table->softDeletes();
        });

        $file_types = [
            [
                'name' => 'PSA Birth Certificate',
                'desc' => 'A copy of the student’s birth certificate issued by the Philippine Statistics Authority (PSA) for identity and student record verification.',
            ],
            [
                'name' => 'Form 137',
                'desc' => 'The student’s official permanent academic record containing the learner’s academic history and grades from the previous school attended.',
            ],
            [
                'name' => 'Form 136',
                'desc' => 'The student’s official report of ratings or scholastic record issued by the previous school for enrollment and academic verification.',
            ],
            [
                'name' => 'School Form 10 (SF10)',
                'desc' => 'The learner’s permanent academic record containing the student’s personal information, academic records, and other required learner information.',
            ],
            [
                'name' => 'Report Card',
                'desc' => 'The student’s official school report card or Form 138 showing academic records from the previous school year or school attended.',
            ],
            [
                'name' => 'Certificate of Good Moral Character',
                'desc' => 'A certificate issued by the student’s previous school confirming the student’s conduct and disciplinary standing.',
            ],
            [
                'name' => 'Certificate of Transfer',
                'desc' => 'An official document issued by the previous school confirming the student’s transfer and enrollment status.',
            ],
            [
                'name' => 'Junior High School Diploma',
                'desc' => 'A copy of the student’s Junior High School completion certificate or diploma confirming completion of Grade 10.',
            ],
            [
                'name' => 'Student ID',
                'desc' => 'A copy of the student’s valid school identification card for identification and verification purposes.',
            ],
            [
                'name' => '2x2 ID Picture',
                'desc' => 'A recent 2x2 identification photograph of the student for school and registrar records.',
            ],
            [
                'name' => 'Parent or Guardian Valid ID',
                'desc' => 'A copy of a valid identification document belonging to the student’s parent or legal guardian for enrollment verification.',
            ],
        ];

        foreach ($file_types as $types) {
            FileType::create($types);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_types');
    }
};
