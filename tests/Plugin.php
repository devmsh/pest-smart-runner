<?php

use Devmsh\PestSmartRunner\Plugin;
use Pest\TestSuite;

it('has plugin', function () {
    assertTrue(class_exists(Plugin::class));
});

it('supports run related class tests if --class exist', function () {
    $plugin = new Plugin();
    $testSuite = TestSuite::getInstance();

    assertNull($plugin->class);
    $arguments = $plugin->handleArguments($testSuite, []);
    assertEquals([], $arguments);
    assertNull($plugin->class);

    $arguments = $plugin->handleArguments($testSuite, ['--class=App\\TestClass']);
    assertEquals([], $arguments);
    assertEquals($plugin->class, 'App\\TestClass');
});
