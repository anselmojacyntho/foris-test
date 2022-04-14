<?php

include(base_path() . '/tests/mocks/FileManagerClass.php');

use PHPUnit\Framework\TestCase;

class FileManagerTest extends TestCase
{
    public $fileName = 'test.txt';
    public $storage  = 'tests/mocks';

    public function testSuccessExtendsFileManagerTrait()
    {
        $manager = new FileManagerClass;

        $this->assertTrue(method_exists($manager, 'createFile'));
        $this->assertTrue(method_exists($manager, 'insertRow'));
        $this->assertTrue(method_exists($manager, 'getContent'));
        $this->assertTrue(method_exists($manager, 'getFilePath'));
    }

    public function testSuccessInCreateAFile()
    {        
        $file = $this->createTestFile();

        $this->assertFileExists($file);

        unlink($file);
    }

    public function testSuccessInInsertStudent()
    {        
        $file = $this->createTestFile();
        
        $manager = new FileManagerClass;

        $row = [
            'Student',
            'AlunoTest'
        ];

        $manager->insertRow($file, $row);
        
        $content = file_get_contents($file);

        $this->assertEquals("Student,AlunoTest\n", $content);

        unlink($file);
    }

    public function testSuccessInInsertPresence()
    {        
        $file = $this->createTestFile();
        
        $manager = new FileManagerClass;

        $row = [
            'Presence',
            'AlunoTest',
            2,
            '09:10',
            '09:30',
            'F100'
        ];

        $manager->insertRow($file, $row);
        
        $content = file_get_contents($file);

        $this->assertEquals("Presence,AlunoTest,2,09:10,09:30,F100\n", $content);

        unlink($file);
    }

    public function testGetContent()
    {        
        $file = base_path() . "/{$this->storage}/input_test_get_content.txt";

        $manager = new FileManagerClass;

        $content = $manager->getContent($file);

        $this->assertInstanceOf(Illuminate\Support\Collection::class, $content);
        $this->assertGreaterThanOrEqual(1, $content->count());
    }

    protected function createTestFile()
    {
        $manager = new FileManagerClass;

        $manager->storagePath = $this->storage;

        $manager->createFile($this->fileName);
        
        return base_path() . "/{$this->storage}/{$this->fileName}";
    }
}