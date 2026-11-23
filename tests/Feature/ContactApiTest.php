<?php

use App\Models\Contact;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('lista solo los contactos del usuario autenticado', function () {
    Sanctum::actingAs($this->user);
    Contact::factory(2)->for($this->user)->create();
    Contact::factory(3)->create();

    $this->getJson('/api/v1/contacts')
        ->assertOk()
        ->assertJsonCount(2, 'data');
});

it('pide token para listar contactos', function () {
    $this->getJson('/api/v1/contacts')->assertUnauthorized();
});

it('muestra un contacto propio', function () {
    Sanctum::actingAs($this->user);
    $contact = Contact::factory()->for($this->user)->create();

    $this->getJson("/api/v1/contacts/{$contact->id}")
        ->assertOk()
        ->assertJsonPath('data.email', $contact->email);
});

it('no deja ver un contacto de otro usuario', function () {
    Sanctum::actingAs($this->user);
    $ajeno = Contact::factory()->create();

    $this->getJson("/api/v1/contacts/{$ajeno->id}")
        ->assertForbidden();
});
it('crea un contacto con datos validos', function () {
    Sanctum::actingAs($this->user);

    $this->postJson('/api/v1/contacts', [
        'first_name' => 'Maria',
        'last_name' => 'Lopez',
        'phone_number' => '3001234567',
        'email' => 'maria@contact.test',
        'address' => 'Calle 10 # 5-20',
    ])
        ->assertCreated()
        ->assertJsonPath('data.email', 'maria@contact.test');

    $this->assertDatabaseHas('contacts', [
        'email' => 'maria@contact.test',
        'user_id' => $this->user->id,
    ]);
});
it('no deja crear un contacto con email repetido', function () {
    Sanctum::actingAs($this->user);
    Contact::factory()->create(['email' => 'repetido@contact.test']);

    $this->postJson('/api/v1/contacts', [
        'first_name' => 'Pedro',
        'last_name' => 'Gomez',
        'phone_number' => '3009998888',
        'email' => 'repetido@contact.test',
        'address' => 'Carrera 3 # 4-5',
    ])->assertUnprocessable();
});

it('elimina un contacto propio con soft delete', function () {
    Sanctum::actingAs($this->user);
    $contact = Contact::factory()->for($this->user)->create();

    $this->deleteJson("/api/v1/contacts/{$contact->id}")
        ->assertNoContent();

    $this->assertSoftDeleted($contact);
});

it('actualiza un contacto propio', function () {
    Sanctum::actingAs($this->user);
    $contact = Contact::factory()->for($this->user)->create();

    $this->putJson("/api/v1/contacts/{$contact->id}", [
        'first_name' => 'Nuevo',
        'last_name' => 'Nombre',
        'phone_number' => $contact->phone_number,
        'email' => $contact->email,
        'address' => 'Calle nueva 123',
    ])
        ->assertOk()
        ->assertJsonPath('data.first_name', 'Nuevo');
});

it('no deja actualizar un contacto de otro usuario', function () {
    Sanctum::actingAs($this->user);
    $ajeno = Contact::factory()->create();

    $this->putJson("/api/v1/contacts/{$ajeno->id}", [
        'first_name' => 'Hack',
        'phone_number' => $ajeno->phone_number,
        'email' => $ajeno->email,
        'address' => 'Calle 1',
    ])->assertForbidden();
});
