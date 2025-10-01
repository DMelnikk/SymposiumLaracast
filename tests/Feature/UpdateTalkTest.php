<?php


use App\Models\Talk;
use App\Models\User;

test('a user can update their talk', function () {
    $talk = Talk::factory()->create();

    $response = $this
        ->actingAs($talk->author)
        ->patch(route('talks.update'   ,$talk), [
            'title' => 'New title here',
            'type' => \App\Enums\TalkType::KEYNOTE->value,
        ]);
    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('talks.show', $talk));


    $this->assertEquals('New title here', $talk->refresh()->title);
});

test('a user can not update other talks', function () {
    $talk = Talk::factory()->create();
    $otherUser = User::factory()->create();
    $originalTitle = $talk->title;

    $response = $this
        ->actingAs($otherUser)
        ->patch(route('talks.update'   ,$talk), [
            'title' => 'New title here',
            'type' => \App\Enums\TalkType::KEYNOTE->value,
        ]);
    $response
        ->assertForbidden();


    $this->assertEquals($originalTitle, $talk->refresh()->title);
});

