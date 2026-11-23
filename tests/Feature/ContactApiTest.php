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
