<?php

test('home page can be rendered', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
});

test('home page describes rural housing mis and garib awas yojana', function () {
    $response = $this->get(route('home'));

    $response->assertSee('Garib Awas Yojana', false);
    $response->assertSee('GIS', false);
    $response->assertSee('rural housing', false);
});

test('home page links to authentication routes for guests', function () {
    $response = $this->get(route('home'));

    $response->assertSee(route('login'), false);
    $response->assertSee(route('register'), false);
});
