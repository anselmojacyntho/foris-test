<?php

include(base_path() . '/tests/mocks/validate_data.php');

use App\Validate;
use PHPUnit\Framework\TestCase;

class ValidatesTest extends TestCase
{
    public function testSuccessWhenAllDataIsCorrect()
    {
        $validate = new Validate;

        $data = correctPresenceData();
        $rules = $this->allRules();

        $validate = $validate->execute($data, $rules);

        $this->assertCount(1, $validate);
        $this->assertArrayHasKey('valid', $validate);
        $this->assertTrue($validate['valid']);
    }

    public function testFailureWhenDayIsInvalid()
    {
        $validate = new Validate;

        $data = dayInvalid();
        $rules = $this->allRules();

        $validate = $validate->execute($data, $rules);
        
        $this->assertCount(2, $validate);
        $this->assertArrayHasKey('valid', $validate);
        $this->assertFalse($validate['valid']);

        foreach ($validate as $rule) {
            if ($rule) {
                $this->assertEquals('isValidDay', $rule['validation']);

                $this->assertFalse($rule['valid']);
            }   
        }
    }

    public function testFailureWhenWorkingHourIsInvalid()
    {
        $validate = new Validate;

        $data = workingHourInvalid();
        $rules = $this->allRules();

        $validate = $validate->execute($data, $rules);
       
        $this->assertCount(2, $validate);
        $this->assertArrayHasKey('valid', $validate);
        $this->assertFalse($validate['valid']);

        foreach ($validate as $rule) {
            if ($rule) {
                $this->assertEquals('isWorkingClass', $rule['validation']);

                $this->assertFalse($rule['valid']);
            }  
        }
    }

    public function testFailureWhenHourIsInvalid()
    {
        $validate = new Validate;

        $data = hourInvalid();
        $rules = $this->allRules();

        $validate = $validate->execute($data, $rules);
       
        $this->assertCount(3, $validate);
        $this->assertArrayHasKey('valid', $validate);
        $this->assertFalse($validate['valid']);

        foreach ($validate as $rule) {
            if ($rule) {
                
                if ($rule['validation'] == 'isValidHour') {
                    $this->assertEquals('isValidHour', $rule['validation']);
                }

                if ($rule['validation'] == 'isWorkingClass') {
                    $this->assertEquals('isWorkingClass', $rule['validation']);
                }

                $this->assertFalse($rule['valid']);
            }               
        }
    }

    public function testFailureWhenHourStartIsGreaterThanEnd()
    {
        $validate = new Validate;

        $data = startGreater();
        $rules = $this->allRules();

        $validate = $validate->execute($data, $rules);
       
        $this->assertCount(3, $validate);
        $this->assertArrayHasKey('valid', $validate);
        $this->assertFalse($validate['valid']);

        foreach ($validate as $rule) {
            if ($rule) {
                
                if ($rule['validation'] == 'isLessThan') {
                    $this->assertEquals('isLessThan', $rule['validation']);
                }

                if ($rule['validation'] == 'isGreaterThan') {
                    $this->assertEquals('isGreaterThan', $rule['validation']);
                }

                $this->assertFalse($rule['valid']);
            }            
        }
    }

    protected function allRules()
    {
        return [
            'day' => 'isValidDay',
            'start' => 'isValidHour|isWorkingClass:start|isLessThan:end',
            'end' => 'isValidHour|isWorkingClass:end|isGreaterThan:start|minimumTime:start'
        ];
    }
}