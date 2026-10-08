<?php

use App\Models\AcademicRecord;
use App\Models\GradeLevel;
use App\Models\Student;
use Livewire\Livewire;

test('renders the grade level index page', function () {
    GradeLevel::create(['name' => '13', 'desc' => 'SHS Grade 13']);

    $this->get(route('grade_levels.index'))
        ->assertOk()
        ->assertSee('13');
});

test('renders an empty grade level index page', function () {
    GradeLevel::query()->forceDelete();

    $this->get(route('grade_levels.index'))
        ->assertOk()
        ->assertSee('No grade levels yet');
});

test('renders the create grade level form', function () {
    $this->get(route('grade_levels.create'))
        ->assertOk()
        ->assertSee('New Grade Level');
});

test('creates a grade level', function () {
    $this->post(route('grade_levels.store'), [
        'name' => '13',
        'desc' => 'SHS Grade 13',
    ])
        ->assertRedirect(route('grade_levels.show', GradeLevel::where('name', '13')->firstOrFail()->id))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('grade_levels', ['name' => '13']);
});

test('rejects a grade level without a name', function () {
    $this->from(route('grade_levels.create'))
        ->post(route('grade_levels.store'), [
            'name' => '',
            'desc' => 'SHS Grade 13',
        ])
        ->assertRedirect(route('grade_levels.create'))
        ->assertSessionHasErrors('name');
});

test('renders the grade level show page with its assigned students', function () {
    $grade_level = GradeLevel::create(['name' => '13', 'desc' => 'SHS Grade 13']);

    $student = Student::factory()->create(['first_name' => 'Juan', 'middle_name' => null, 'last_name' => 'Dela Cruz']);
    AcademicRecord::factory()->for($student)->gradeLevel($grade_level)->create();

    $this->get(route('grade_levels.show', $grade_level->id))
        ->assertOk()
        ->assertSee('Grade 13')
        ->assertSee('Dela Cruz');
});

test('renders the edit grade level form', function () {
    $grade_level = GradeLevel::create(['name' => '13', 'desc' => 'SHS Grade 13']);

    $this->get(route('grade_levels.edit', $grade_level->id))
        ->assertOk()
        ->assertSee('Edit Grade Level')
        ->assertSee('SHS Grade 13', false);
});

test('updates a grade level', function () {
    $grade_level = GradeLevel::create(['name' => '13', 'desc' => 'SHS Grade 13']);

    $this->put(route('grade_levels.update', $grade_level->id), [
        'name' => '13 Advanced',
        'desc' => 'SHS Grade 13 advanced track',
    ])
        ->assertRedirect(route('grade_levels.show', $grade_level->id))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('grade_levels', ['id' => $grade_level->id, 'name' => '13 Advanced']);
});

test('rejects a grade level update with an empty description', function () {
    $grade_level = GradeLevel::create(['name' => '13', 'desc' => 'SHS Grade 13']);

    $this->from(route('grade_levels.edit', $grade_level->id))
        ->put(route('grade_levels.update', $grade_level->id), [
            'name' => '13',
            'desc' => '',
        ])
        ->assertRedirect(route('grade_levels.edit', $grade_level->id))
        ->assertSessionHasErrors('desc');
});

test('soft deletes a grade level', function () {
    $grade_level = GradeLevel::create(['name' => '13', 'desc' => 'SHS Grade 13']);

    $this->delete(route('grade_levels.destroy', $grade_level->id))
        ->assertRedirect(route('grade_levels.index'))
        ->assertSessionHas('success');

    $this->assertSoftDeleted('grade_levels', ['id' => $grade_level->id]);
});

test('deletes a grade level from the index table', function () {
    $grade_level = GradeLevel::create(['name' => '13', 'desc' => 'SHS Grade 13']);

    Livewire::test('application.index_grade_level')
        ->call('destroy', $grade_level->id)
        ->assertDontSee('SHS Grade 13');

    $this->assertSoftDeleted('grade_levels', ['id' => $grade_level->id]);
});
