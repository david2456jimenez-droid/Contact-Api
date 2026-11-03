<?php

use App\Models\Contact;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

it('relaciona el contacto con su dueño', function () {
    $user = User::factory()->create();
    $contact = Contact::factory()->for($user)->create();

    expect($contact->user->is($user))->toBeTrue()
        ->and($user->contacts)->toHaveCount(1);
});

it('agrupa los contactos de cada usuario', function () {
    $ana = User::factory()->create();
    $luis = User::factory()->create();

    Contact::factory(3)->for($ana)->create();
    Contact::factory(2)->for($luis)->create();

    expect($ana->contacts)->toHaveCount(3)
        ->and($luis->contacts)->toHaveCount(2);
});

it('siembra los usuarios y contactos de ejemplo', function () {
    $this->seed(DatabaseSeeder::class);

    expect(User::where('email', 'uno@gmail.com')->exists())->toBeTrue()
        ->and(User::count())->toBe(3)
        ->and(Contact::count())->toBe(8);
});
