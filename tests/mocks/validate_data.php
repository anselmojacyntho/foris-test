<?php

function correctPresenceData() {
    return [
        'day' => 2,
        'start' => '09:10',
        'end' => '10:00'
    ];
}

function dayInvalid() {
    return [
        'day' => 8,
        'start' => '09:10',
        'end' => '10:00'
    ];
}

function workingHourInvalid() {
    return [
        'day' => 2,
        'start' => '03:10',
        'end' => '10:00'
    ];
}

function hourInvalid() {
    return [
        'day' => 2,
        'start' => '09:10',
        'end' => '27:00'
    ];
}

function startGreater() {
    return [
        'day' => 2,
        'start' => '10:10',
        'end' => '09:00'
    ];
}
