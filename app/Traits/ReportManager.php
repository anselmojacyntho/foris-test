<?php

namespace App\Traits;

trait ReportManager {

    public function studentByClass($data)
    {                
        $list = $data->map(function($register) use ($data) {
            if ($register[0] == 'Presence') {
                return $register; 
            }
        });   

        $students = $list->filter()->groupBy(function ($item, $key) {
            return $item[1];
        });

        $sorted = $students->sortBy(function ($student, $key) {
            dump($student);
            return $student[2];
        });

        $response = $sorted->reduce(function($day, $item) {
            dd($item);   
            
        });

        dd($response);

        dd($this->getClasses($list));
    }

    public function getClasses($list)
    {
    }
}