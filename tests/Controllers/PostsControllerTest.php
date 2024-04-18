<?php

namespace Tests\Controllers;

use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\CIUnitTestCase;
use App\Controllers\PostsController;

class PostsControllerTest extends CIUnitTestCase {
    use ControllerTestTrait;

    protected function setUp(): void
    {
        parent::setUp();

        // Set the CI environment to 'testing'
        putenv('CI_ENVIRONMENT=testing');

        // You can load any other necessary resources here
    }

    public function testIndex()
    {
        $response = $this->withURI('http://localhost/posts')
            ->controller(PostsController::class)
            ->execute('index');

        // Assert status code
        $this->assertTrue($response->isOK());

        // Assert that the body contains specific text
        $this->assertStringContainsString('Welcome To SportPost', $response->getBody());

        // More specific assertions
    }
}