<?php

include_once(base_path() . '/tests/mocks/DataManipulatorClass.php');
include_once(base_path() . '/tests/mocks/FileManagerClass.php');

use PHPUnit\Framework\TestCase;

class DataManipulatorTest extends TestCase
{
    public function testCheckStudentExists()
    {
        $content = $this->getContents();
        $manipulator = new DataManipulatorClass;

        $this->assertTrue($manipulator->studentExists($content, 'Teste1'));                
    }

    public function testGetStudentDataByName()
    {
        $content = $this->getContents();
        $manipulator = new DataManipulatorClass;

        $student = $manipulator->getStudent($content, 'Teste1');

        $this->assertInstanceOf(Illuminate\Support\Collection::class, $student);
        
        foreach ($student as $register) {
            $this->assertEquals('Teste1', $register[1]);
        }
    }

    public function testCalcTimeInClass()
    {
        $content = $this->getContents();
        $manipulator = new DataManipulatorClass;

        $presences = $manipulator->getData($content, 'Teste1');

        $calc = $manipulator->timeInClass('Teste1', $presences);

        $this->assertTrue(is_array($calc));
        $this->assertArrayHasKey('name', $calc);
        $this->assertArrayHasKey('time', $calc);
        $this->assertArrayHasKey('message', $calc);
        $this->assertTrue(is_string($calc['name']));
        $this->assertTrue(is_int($calc['time']));
        $this->assertTrue(is_string($calc['message']));
    }

    protected function getContents()
    {
        $fileManager = new FileManagerClass;
        $fileName = base_path() . "/tests/mocks/input_test_get_content.txt";

        return $fileManager->getContent($fileName);
    }
}