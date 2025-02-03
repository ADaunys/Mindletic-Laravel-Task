<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
    * The base URL for all requests during tests.
    *
    * @var string
    */
    protected $baseUrl = 'http://localhost/api';
}
