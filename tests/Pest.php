<?php

use AKM\Biovel\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

// Cleanup Mockery setelah setiap test
afterEach(function () {
    if (class_exists(\Mockery::class)) {
        \Mockery::close();
    }
});
