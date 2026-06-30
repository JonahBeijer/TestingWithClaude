<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_notes_index_requires_auth(): void
    {
        $this->get(route('notes.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_notes_index(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('notes.index'))->assertOk();
    }

    public function test_user_can_create_a_note(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('notes.store'), [
            'title' => 'Test notitie',
            'body'  => 'Inhoud van de notitie.',
        ]);

        $response->assertRedirect(route('notes.index'));
        $this->assertDatabaseHas('notes', [
            'user_id' => $user->id,
            'title'   => 'Test notitie',
            'body'    => 'Inhoud van de notitie.',
        ]);
    }

    public function test_title_is_required(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('notes.store'), ['title' => '', 'body' => 'tekst'])
            ->assertSessionHasErrors('title');
    }

    public function test_user_can_update_own_note(): void
    {
        $user = User::factory()->create();
        $note = $user->notes()->create(['title' => 'Oud', 'body' => null]);

        $response = $this->actingAs($user)->patch(route('notes.update', $note), [
            'title' => 'Nieuw',
            'body'  => 'Bijgewerkt.',
        ]);

        $response->assertRedirect(route('notes.index'));
        $this->assertDatabaseHas('notes', ['id' => $note->id, 'title' => 'Nieuw']);
    }

    public function test_user_cannot_update_another_users_note(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $note  = $owner->notes()->create(['title' => 'Geheim', 'body' => null]);

        $this->actingAs($other)
            ->patch(route('notes.update', $note), ['title' => 'Gehackt', 'body' => null])
            ->assertForbidden();
    }

    public function test_user_can_delete_own_note(): void
    {
        $user = User::factory()->create();
        $note = $user->notes()->create(['title' => 'Te verwijderen', 'body' => null]);

        $this->actingAs($user)
            ->delete(route('notes.destroy', $note))
            ->assertRedirect(route('notes.index'));

        $this->assertDatabaseMissing('notes', ['id' => $note->id]);
    }

    public function test_user_cannot_delete_another_users_note(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $note  = $owner->notes()->create(['title' => 'Beschermd', 'body' => null]);

        $this->actingAs($other)
            ->delete(route('notes.destroy', $note))
            ->assertForbidden();
    }
}
