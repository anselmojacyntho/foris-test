<?php

namespace App;

use Carbon\Carbon;

class Validate {

    public $workingHour = ['start' => '06:00', 'end' => '23:59'];

    // Time in minutes
    public $minimumMinutesTime = 5;

    public function execute($data, $validates)
    {
        $response = [];
        $valid = true;

        foreach($validates as $field => $rules) {
            if (isset($data[$field])) {
                $rules = explode('|', $rules);
                
                foreach($rules as $rule) {
                    
                    $rule = explode(':', $rule);

                    if (method_exists($this, $rule[0])) {

                        $validate = $this->{$rule[0]}($data, $field, $rule);

                        if (!$validate) {
                            $valid = false;

                            array_push($response, [
                                'field' => $field,
                                'validation' => $rule[0],
                                'valid' => $validate
                            ]); 
                        }                        
                    }
                }                
            }
        }   
        
        $response['valid'] = $valid;
        
        return $response;
    }

    public function printMessages($messages)
    {
        foreach( $messages as $message) {
            if (isset($message['validation'])) {
                $rule = $message['validation'];                
                echo "{$this->messages()[$rule]}\n";
            }            
        }
    }

    public function messages()
    {
        return [
            'isValidDay' => 'Dia da semana inválido',
            'isWorkingClass' => 'Hora informada está fora do horário de aulas',
            'isValidHour' => 'Hora informada inválida',
            'isGreaterThan' => 'Hora informada nao é maior que a inicial',
            'isLessThan' => 'Hora informada nao é menor que a final',
            'minimumTime' => 'Registro nao possui o tempo minimo de aula'
        ];
    }

    public function isValidDay($data, $field, $rule)
    {        
        return $data[$field] > 0 && $data[$field] < 8 ? true : false; 
    }

    public function isValidHour($data, $field, $rule)
    {
        $time = explode(':',$data[$field]);
        
        $valid = ($time[0] < 0 || $time[0] > 23 ) ? false : true;

        if ($valid) {
            $valid = ($time[1] < 0 || $time[0] > 59 ) ? false : true;
        }

        return $valid;
    }

    public function isWorkingClass($data, $field, $rule)
    {
        $workingHour = explode(':', $this->workingHour[$rule[1]]);
        $time = explode(':', $data[$field]);

        $valid = false;

        if ($rule[1] == 'start') {
            $valid = ($time[0] > $workingHour[0]) ? true : false;

            if ($time[0] == $workingHour[0]) {
                $valid = ($time[1] >= $workingHour[1]) ? true : false;
            }            
        }

        if ($rule[1] == 'end') {
            $valid = ($time[0] < $workingHour[0]) ? true : false;

            if ($time[0] == $workingHour[0]) {
                $valid = ($time[1] <= $workingHour[1]) ? true : false;
            }  
        }
        
        return $valid;
    }

    public function isGreaterThan($data, $field, $rule)
    {
        $time = explode(':', $data[$field]);
        $compare = explode(':', $data[$rule[1]]);

        $valid = $time[0] > $compare[0] ? true : false;

        if ($time[0] == $compare[0]) {
            $valid = $time[1] >= $compare[1] ? true : false;
        }

        return $valid;      
    }

    public function isLessThan($data, $field, $rule)
    {
        $time = explode(':', $data[$field]);
        $compare = explode(':', $data[$rule[1]]);
        
        $valid = $time[0] < $compare[0] ? true : false;

        if ($time[0] == $compare[0]) {
            $valid = $time[1] <= $compare[1] ? true : false;
        }

        return $valid;     
    }

    public function minimumTime($data, $field, $rule)
    {
        $time = Carbon::createFromFormat('H:i', $data[$field]);
        $compare = Carbon::createFromFormat('H:i',$data[$rule[1]]);

        return $time->diffInMinutes($compare) >= $this->minimumMinutesTime ? true : false;
    }
}