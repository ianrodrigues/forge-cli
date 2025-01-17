<?php

it('can display the database status running', function () {
    $this->client->shouldReceive('server')->andReturn(
        (object) ['id' => 1, 'name' => 'production', 'databaseType' => 'mysql', 'ipAddress' => '123.456.789.222'],
    );

    $this->remote->shouldReceive('exec')->andReturn([0]);

    $this->artisan('database:status')->expectsOutput('==> The Database Is Up & Running');
});

it('can display the database status as inactive', function () {
    $this->client->shouldReceive('server')->andReturn(
        (object) ['id' => 1, 'name' => 'production', 'databaseType' => 'mysql', 'ipAddress' => '123.456.789.222'],
    );

    $this->remote->shouldReceive('exec')->andReturn([3]);

    $this->artisan('database:status');
})->throws('Service is not running.');

it('can not display the status when there is no database', function () {
    $this->client->shouldReceive('server')->andReturn(
        (object) ['id' => 1, 'name' => 'production', 'databaseType' => null],
    );

    $this->artisan('database:status');
})->throws('No databases installed in this server.');
