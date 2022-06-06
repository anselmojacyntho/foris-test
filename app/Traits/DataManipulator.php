<?php

namespace App\Traits;

use Carbon\Carbon;
trait DataManipulator {

    public function studentExists($data, $name)
    {
       $check = $this->getStudent($data, $name);

       return count($check) > 0 ? true : false;
    }

    public function getStudent($data, $name)
    {        
        return $data->filter(function($v, $i) use ($name){
            if ($v[1] == $name ) {                
                return $v;
            }
        });        
    }

    public function getData($data, $name, $command = 'Presence')
    {
        return $this->getStudent($data, $name)->filter(function($register) use ($command) {
            if ($register[0] == $command) {
                return $register;
            }
        });
    }

    public function classAttendanceTimeList($data, $command = 'Student')
    {
        $list = $data->map(function($register) use ($data, $command) {
            if ($register[0] == $command) {
                $presences = $this->getData($data, $register[1]);
                return $this->timeInClass($register[1], $presences);
            }
        });

        return $list->filter()->unique()->sortBy('time')->reverse()->all();        
    }
    
    public function timeInClass($student, $presences)
    {   
        $time = 0;
        $name = null;
        
        $message = "0 minutes";

        if ($presences->count() > 0 ) {
            foreach( $presences as $presence ) {
                $start = Carbon::createFromFormat('H:i', $presence[3]);
                $end = Carbon::createFromFormat('H:i', $presence[4]); 
        
                $time += $start->diffInMinutes($end);
            }
            
            $is_plural =  ($presences->count() > 1) ? "days" : "day";

            $message = "{$time} minutes in {$presences->count()} {$is_plural}";
        }

        return [
            "name" => $student,
            "time" => $time,
            "message" => $message
        ];
    }
}