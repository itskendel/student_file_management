<?php

use App\Models\AcademicRecord;
use App\Models\SchoolYear;
use App\Models\Student;
use Livewire\Livewire;

test('renders the school year index page', function () {
    SchoolYear::create(['name' => '2027 - 2028', 'desc' => 'S.Y. 2027 - 2028']);

    $this->get(route('school_years.index'))
        ->assertOk()
        ->assertSee('2027 - 2028');
});

test('renders an empty school year index page', function () {
    SchoolYear::query()->forceDelete();

    $this->get(route('school_years.index'))
        ->assertOk()
        ->assertSee('No school years yet');
});

test('renders the create school year form', function () {
    $this->get(route('school_years.create'))
        ->assertOk()
        ->assertSee('New School Year');
});

test('creates a school year', function () {
    $this->post(route('school_years.store'), [
        'name' => '2027 - 2028',
        'desc' => 'S.Y. 2027 - 2028',
    ])
        ->assertRedirect(route('school_years.show', SchoolYear::where('name', '2027 - 2028')->firstOrFail()->id))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('school_years', ['name' => '2027 - 2028']);
});

test('rejects a school year without a name', function () {
    $this->from(route('school_years.create'))
        ->post(route('school_years.store'), [
            'name' => '',
            'desc' => 'S.Y. 2027 - 2028',
        ])
        ->assertRedirect(route('school_years.create'))
        ->assertSessionHasErrors('name');
});

test('renders the school year show page with its assigned students', function () {
    $school_year = SchoolYear::create(['name' => '2027 - 2028', 'desc' => 'S.Y. 2027 - 2028']);

    $student = Student::factory()->create(['first_name' => 'Juan', 'middle_name' => null, 'last_name' => 'Dela Cruz']);
    AcademicRecord::factory()->for($student)->schoolYear($school_year)->create();

    $this->get(route('school_years.show', $school_year->id))
        ->assertOk()
        ->assertSee('2027 - 2028')
        ->assertSee('Dela Cruz');
});

test('renders the edit school year form', function () {
    $school_year = SchoolYear::create(['name' => '2027 - 2028', 'desc' => 'S.Y. 2027 - 2028']);

    $this->get(route('school_years.edit', $school_year->id))
        ->assertOk()
        ->assertSee('Edit School Year')
        ->assertSee('S.Y. 2027 - 2028', false);
});

test('updates a school year', function () {
    $school_year = SchoolYear::create(['name' => '2027 - 2028', 'desc' => 'S.Y. 2027 - 2028']);

    $this->put(route('school_years.update', $school_year->id), [
        'name' => '2027 - 2028 Extended',
        'desc' => 'S.Y. 2027 - 2028 extended',
    ])
        ->assertRedirect(route('school_years.show', $school_year->id))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('school_years', ['id' => $school_year->id, 'name' => '2027 - 2028 Extended']);
});

test('rejects a school year update with an empty description', function () {
    $school_year = SchoolYear::create(['name' => '2027 - 2028', 'desc' => 'S.Y. 2027 - 2028']);

    $this->from(route('school_years.edit', $school_year->id))
        ->put(route('school_years.update', $school_year->id), [
            'name' => '2027 - 2028',
            'desc' => '',
        ])
        ->assertRedirect(route('school_years.edit', $school_year->id))
        ->assertSessionHasErrors('desc');
});

test('soft deletes a school year', function () {
    $school_year = SchoolYear::create(['name' => '2027 - 2028', 'desc' => 'S.Y. 2027 - 2028']);

    $this->delete(route('school_years.destroy', $school_year->id))
        ->assertRedirect(route('school_years.index'))
        ->assertSessionHas('success');

    $this->assertSoftDeleted('school_years', ['id' => $school_year->id]);
});

test('deletes a school year from the index table', function () {
    $school_year = SchoolYear::create(['name' => '2027 - 2028', 'desc' => 'S.Y. 2027 - 2028']);

    Livewire::test('application.index_school_year')
        ->call('destroy', $school_year->id)
        ->assertDontSee('2027 - 2028');

    $this->assertSoftDeleted('school_years', ['id' => $school_year->id]);
});
