<?php

namespace App\Enums;

final class SelectionInfoEnum
{
    const START_ROW = 2;
    const START_COLUMN = 1;

    // Indexing started from 0
    const PROCEDURE_NUMBER = 1; // B
    const LOT_NUMBER = 2; // C
    const LOT_SUBJECT = 3; // D
    const STATUS_NAME = 6; // G
    const STEP_NAME = 7; // H
    const STARTED_AT = 8; // I
    const ENDED_AT = 9; // J
    const PROPOSALS_NUMBER = 11; // L

    const RELATION = [
        self::PROCEDURE_NUMBER => 'procedure_number',
        self::LOT_NUMBER => 'lot_number',
        self::LOT_SUBJECT => 'lot_subject',
        self::STATUS_NAME => 'status_name',
        self::STEP_NAME => 'step_name',
        self::STARTED_AT => 'started_at',
        self::ENDED_AT => 'ended_at',
        self::PROPOSALS_NUMBER => 'proposals_number',
    ];

    const TO_DATE = [
        self::STARTED_AT,
        self::ENDED_AT,
    ];

    const VALIDATION_RULES = [
        'procedure_number' => 'required|string|max:255',
        'lot_number' => 'required|string|max:255',
        'lot_subject' => 'nullable|string|max:255',
        'status_name' => 'nullable|string|max:255',
        'step_name' => 'nullable|string|max:255',
        'started_at' => 'nullable|date',
        'ended_at' => 'nullable|date',
        'proposals_number' => 'nullable|integer',
    ];
}
