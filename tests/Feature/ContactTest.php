<?php

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

// Usa RefreshDatabase para limpiar la base de datos de pruebas después de cada test
uses(RefreshDatabase::class);

test('un usuario puede tener multiples contactos', function () {
    // 1. Arrange: Creamos un usuario de prueba
    $user = User::factory()->create();

    // 2. Act: Creamos contactos asociados a ese usuario
    Contact::factory()->count(3)->create([
        'user_id' => $user->id,
    ]);

    // 3. Assert: Verificamos que la relación devuelve los 3 contactos
    expect($user->contacts)->toHaveCount(3);
    expect($user->contacts->first())->toBeInstanceOf(Contact::class);
});

test('un contacto pertenece a un usuario', function () {
    // 1. Arrange & Act: Creamos un contacto (esto automáticamente crea su usuario gracias al factory)
    $contact = Contact::factory()->create();

    // 2. Assert: Verificamos que la relación 'user' trae una instancia válida de User
    expect($contact->user)->toBeInstanceOf(User::class);
    expect($contact->user_id)->toBe($contact->user->id);
});
