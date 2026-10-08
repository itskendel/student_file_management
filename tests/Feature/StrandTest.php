<?php

use App\Models\AcademicRecord;
use App\Models\Strand;
use App\Models\Student;
use Livewire\Livewire;

test('renders the strand index page', function () {
    Strand::create(['name' => 'TVL', 'desc' => 'Technical-Vocational-Livelihood']);

    $this->get(route('strands.index'))
        ->assertOk()
        ->assertSee('TVL');
});

test('renders an empty strand index page', function () {
    Strand::query()->forceDelete();

    $this->get(route('strands.index'))
        ->assertOk()
        ->assertSee('No strands yet');
});

test('renders the create strand form', function () {
    $this->get(route('strands.create'))
        ->assertOk()
        ->assertSee('New Strand');
});

test('creates a strand', function () {
    $this->post(route('strands.store'), [
        'name' => 'TVL',
        'desc' => 'Technical-Vocational-Livelihood',
    ])
        ->assertRedirect(route('strands.show', Strand::where('name', 'TVL')->firstOrFail()->id))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('strands', ['name' => 'TVL']);
});

test('rejects a strand without a name', function () {
    $this->from(route('strands.create'))
        ->post(route('strands.store'), [
            'name' => '',
            'desc' => 'Technical-Vocational-Livelihood',
        ])
        ->assertRedirect(route('strands.create'))
        ->assertSessionHasErrors('name');
});

test('renders the strand show page with its assigned students', function () {
    $strand = Strand::create(['name' => 'TVL', 'desc' => 'Technical-Vocational-Livelihood']);

    $student = Student::factory()->create(['first_name' => 'Juan', 'middle_name' => null, 'last_name' => 'Dela Cruz']);
    AcademicRecord::factory()->for($student)->strand($strand)->create();

    $this->get(route('strands.show', $strand->id))
        ->assertOk()
        ->assertSee('TVL')
        ->assertSee('Dela Cruz');
});

test('renders the edit strand form', function () {
    $strand = Strand::create(['name' => 'TVL', 'desc' => 'Technical-Vocational-Livelihood']);

    $this->get(route('strands.edit', $strand->id))
        ->assertOk()
        ->assertSee('Edit Strand')
        ->assertSee('Technical-Vocational-Livelihood', false);
});

test('updates a strand', function () {
    $strand = Strand::create(['name' => 'TVL', 'desc' => 'Technical-Vocational-Livelihood']);

    $this->put(route('strands.update', $strand->id), [
        'name' => 'TVL Core',
        'desc' => 'Technical-Vocational-Livelihood track',
    ])
        ->assertRedirect(route('strands.show', $strand->id))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('strands', ['id' => $strand->id, 'name' => 'TVL Core']);
});

test('rejects an update with an empty description', function () {
    $strand = Strand::create(['name' => 'TVL', 'desc' => 'Technical-Vocational-Livelihood']);

    $this->from(route('strands.edit', $strand->id))
        ->put(route('strands.update', $strand->id), [
            'name' => 'TVL',
            'desc' => '',
        ])
        ->assertRedirect(route('strands.edit', $strand->id))
        ->assertSessionHasErrors('desc');
});

test('soft deletes a strand', function () {
    $strand = Strand::create(['name' => 'TVL', 'desc' => 'Technical-Vocational-Livelihood']);

    $this->delete(route('strands.destroy', $strand->id))
        ->assertRedirect(route('strands.index'))
        ->assertSessionHas('success');

    $this->assertSoftDeleted('strands', ['id' => $strand->id]);
});

test('deletes a strand from the index table', function () {
    $strand = Strand::create(['name' => 'TVL', 'desc' => 'Technical-Vocational-Livelihood']);

    Livewire::test('application.index_strand')
        ->call('destroy', $strand->id)
        ->assertDontSee('TVL');

    $this->assertSoftDeleted('strands', ['id' => $strand->id]);
});
