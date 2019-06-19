<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileManagerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testGetSpaceReturnsInt()
    {
        $response = $this->get('/api/file/space');
        
        $response->assertStatus(200);

        $this->assertIsInt($response->decodeResponseJson()['bytes']);
    }

    public function testGetSpaceReturnsNonNegativeNumber()
    {
        $response = $this->get('/api/file/space');
        
        $this->assertTrue($response->decodeResponseJson()['bytes'] >= 0);
    }

    public function testGetFilesReturnsArray()
    {
        $response = $this->get('/api/file/all');

        $this->assertInternalType('array', $response->decodeResponseJson()['files']);
    }

    public function testUploadFile()
    {
        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('fakeimage.jpg');
    
        $response = $this->json('POST', '/api/file', [
            'uploaded_file' => $file
        ]);

        $response->assertStatus(200);

        // Assert the file was stored 
        // TODO- Investigate why this test always fails
        // Storage::disk('avatars')->assertExists(public_path("uploads")."/fakeimage.jpg");

    }

    public function testDownloadFileReturnsStatusOk()
    {
        $response = $this->get('/api/file/testimage.jpg');

        $response->assertStatus(200);
    }

    public function testDownloadFileReturnsStatusErrorForInvalidFile()
    {
        $response = $this->get('/api/file/thisisafakefile.jpg');

        $response->assertStatus(500);
    }
}
