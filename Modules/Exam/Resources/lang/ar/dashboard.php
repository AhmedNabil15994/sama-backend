<?php

return [
    'exams'     => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'form'      => [
            'status'    => 'الحالة',
            'tabs'      => [
                'general'   => 'بيانات عامة',
            ],
            'title'              => 'العنوان',
            'degree'             => 'الدرجه النهائيه',
            'success_degree'     => 'درجه النجاح',
            'color'              => 'اللون',
            'duration'          =>'(دقيقه) مده الامتحان'
        ],
        'routes'    => [
            'create'    => 'اضافة اختبار',
            'index'     => 'اختبار',
            'update'    => 'تعديل اختبار',
        ],

    ],


    'answers'   => [
        'form'  => [
            'answer' => 'الاجابه',
        ],
    ],
    'questions'      => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'question'         => 'السؤال',
        ],
        'form'      => [
            'restore'           => 'استرجاع من الحذف',
            'exams'             => 'الامتحانات',
            'tabs'              => [
                'answers'   => 'الاجابات',
                'general'   => 'بيانات عامة',
            ],
            'types'              => [
                'question'   => 'سؤال',
                'audio'      => 'ملف صوتي',
            ],
            'question'            => 'السؤال',
            'type'                => 'نوع السؤال ',
            'with-audio'          => 'مع ملف صوت ',
            'audio'               => ' ملف صوت',
            'degree'              => 'الدرجه',
            'image'               => ' صورة ',
            'is_correct'              => 'الاجابة صحيحة',
        ],
        'routes'    => [
            'create'    => 'اضافة الاسئلة',
            'index'     => 'الاسئلة',
            'update'    => 'تعديل السؤال',
        ],
    ],

     'userexams' => [
        'datatable' => [
            'failed'        => 'فشل علية الرفع',
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'user'          => 'الطالب',
            'exam'          => 'الامتحان',
            'course'        => 'المادة',
            'trainer'       => 'المدرس',
        ],
        'user'=>'الطالب',
        'exam'=>'الامتحان',
        'show'=> [
                'hours'=>'ساعه',
                'corrected_answers'=>'الاجابات الصحيحه',
                'no_questions'=>'عدد الاسئلة',
                'result' => 'مجموع الدرجات',
                'of' => ' من ',
                'not_answered' => 'لم يتم الاجابة',
                'question' => 'السؤال',
                'correct_answer' => 'الاجابة الصحيحة',
                'degree' => 'درجة السؤال',
                'user_answer'   => 'اجابة الطالب',
                'is_correct'    => 'صحيحه؟',
          ],
        'routes' => [
            'index' => 'امتحانات الطلبه',
            'show' => 'عرض  امتحان الطالب',
        ],
    ],


];
