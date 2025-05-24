<?php

return [
    'exams'     => [
        'datatable' => [
            'created_at'    => 'Created at',
            'options'       => 'Options',
            'state'         => 'State',
            'status'        => 'Status',
            'title'         => 'Title',
        ],
        'form'      => [
            'status'    => 'Status',
            'tabs'      => [
                'general'   => 'General Info.',
            ],
            'title'     => 'Title',
            'degree'             => 'degree',
            'success_degree'     => 'success degree',
            'color'              => 'Color',
            'duration'          =>'exam duration (minute)',
        ],
        'routes'    => [
            'create'    => 'Create Exam',
            'index'     => 'Exam',
            'update'    => 'Update Exam',
        ],

    ],
    'answers'   => [
        'form'  => [
            'answer' => 'Answer',
        ],
    ],
    'questions'      => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'options'       => 'Options',
            'status'        => 'Status',
            'question'      => 'Question',
        ],
        'form'      => [
            'restore'           => 'Restore from trash',
            'tabs'              => [
                'answers'   => 'Answers',
                'general'   => 'General Info.',
            ],
            'question'             => 'Question',
            'degree'              => 'degree',
            'is_correct'              => 'Correct Answer',
            'with-audio'           => 'with Audio',
            'audio'               => ' audio ',
            'exams'               => ' exams ',
            'image'               => ' image ',
        ],
        'routes'    => [
            'create'    => 'Create Question',
            'index'     => 'Question',
            'update'    => 'Update Question',
        ],

    ],

     'userexams' => [
        'datatable' => [
            'created_at'    => 'created at',
            'date_range'    => 'date range',
            'options'       => 'options',
            'status'        => 'status',
            'user'          => 'Student',
            'exam'          => 'Exam',
            'course'        => 'Course',
            'trainer'       => 'Trainer',

        ],
        'user'=>'exam',
        'show'=> [
                'hours'=>'Hours',
                'corrected_answers'=>'Correct answer',
                'no_questions'=>'Questions No.',
                'result' => 'Exam Result',
                'of' => ' OF ',
                'not_answered' => 'Not Answered',
                'question' => 'Question',
                'correct_answer' => 'Correct Answer',
                'degree' => 'Degree',
                'user_answer'   => 'User Answer',
                'is_correct'    => 'Is Correct?',
          ],
        'routes' => [
            'show' => 'show user exam',
            'index' => 'users exams',

        ],
    ],
];
