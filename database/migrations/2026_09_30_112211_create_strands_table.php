<?php

use App\Models\Strand;
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
        Schema::create('strands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('desc');
            $table->timestamps();
            $table->softDeletes();
        });

        $strands = [
            ['name' => 'ICT',  'desc' => 'Information and Communication Technology'],
            ['name' => 'ABM',  'desc' => 'Accountancy, Business, and Management'],
            ['name' => 'STEM', 'desc' => 'Science, Technology, Engineering, and Mathematics'],
            ['name' => 'HUMSS', 'desc' => 'Humanities and Social Sciences'],
        ];

        foreach ($strands as $strand) {
            Strand::create($strand);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strands');
    }
};
