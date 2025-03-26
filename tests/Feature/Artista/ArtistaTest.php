<?php

use App\Models\Artista;
use App\Models\Cidade;
use App\Models\User;
use Database\Seeders\CidadeSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    (new CidadeSeeder)->run();
});

test('index displays artistas', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Artista::factory()->count(5)->create();

    $response = $this->get(route('artistas.index'));

    $response->assertStatus(200)
        ->assertInertia(fn($page) => $page->has('artistas'));
});

test('create displays form', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('artistas.create'));

    $response->assertStatus(200)
        ->assertInertia(fn($page) => $page->has('cidades'));
});

test('store creates artista', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Storage::fake('local');
    $cidade = Cidade::inRandomOrder()->first();
    $data = Artista::factory()->make(['cidade_id' => $cidade->id])->toArray();
    $data['logo_path'] = UploadedFile::fake()->image('logo.jpg');

    $response = $this->post(route('artistas.store'), $data);

    $response->assertRedirect();
    $this->assertDatabaseHas('artistas', ['nome' => $data['nome']]);
});

test('edit displays form with artista', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $artista = Artista::factory()->create();

    $response = $this->get(route('artistas.edit', $artista));

    $response->assertStatus(200)
        ->assertInertia(fn($page) => $page->has('artista')->has('cidades'));
});

test('update modifies artista', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $artista = Artista::factory()->create();
    $newData = $artista->toArray();
    $newData['nome'] = 'Novo Nome';
    $newData['logo_path'] = UploadedFile::fake()->image('logo.jpg');

    $response = $this->put(route('artistas.update', $artista), $newData);


    $response->assertRedirect();
    $this->assertDatabaseHas('artistas', ['id' => $artista->id, 'nome' => 'Novo Nome']);
});
