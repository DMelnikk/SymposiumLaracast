<?php

use App\Console\Commands\ImportConferences;
use App\Models\Conference;

test('it import a conference', function () {
    $command = new ImportConferences();

    $data = [
        'name' => 'This is name from the api',
        '_rel' => ['cfp_uri' => 'v1/cfp/01341dasdas']
    ];

    $command->importOrUpdateConference($data);

    $first = Conference::first();
    $this->assertEquals($first->title, $data['name']);
});



