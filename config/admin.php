<?php

return [
    'admins' => [
        [
            'element' => 'input',
            'type' => 'text',
            'name' => 'name',
            'label' => 'Имя',
            'required' => true,
            'readonly' => false,
            'value' => '',
        ],
        [
            'element' => 'input',
            'type' => 'text',
            'name' => 'surname',
            'label' => 'Фамилия',
            'required' => false,
            'readonly' => false,
            'value' => '',
        ],
        [
            'element' => 'input',
            'type' => 'email',
            'name' => 'email',
            'label' => 'Email',
            'required' => true,
            'readonly' => false,
            'value' => '',
        ],
        [
            'element' => 'input',
            'type' => 'password',
            'name' => 'password',
            'label' => 'Пароль',
            'required' => false,
            'readonly' => false,
            'value' => '',
        ],
        [
            'element' => 'input',
            'type' => 'password',
            'name' => 'password_confirmation',
            'label' => 'Повторить пароль',
            'required' => false,
            'readonly' => false,
            'value' => '',
        ],
        [
            'element' => 'checkbox',
            'type' => 'checkbox',
            'name' => 'active',
            'label' => 'Активен',
            'required' => false,
            'readonly' => false,
            'value' => '1',
        ],
    ],
    'courses' => [
        [
            'element' => 'input',
            'type' => 'text',
            'name' => 'name',
            'label' => 'Название',
            'required' => true,
            'readonly' => false,
            'value' => '',
        ],
        [
            'element' => 'textarea',
            'type' => 'textarea',
            'name' => 'description',
            'label' => 'Описание',
            'required' => true,
            'readonly' => false,
            'value' => '',
        ],
        [
            'element' => 'input-img',
            'type' => 'file',
            'accept' => 'image/png, image/jpeg',
            'name' => 'img',
            'label' => 'Изображение',
            'required' => false,
            'readonly' => false,
            'value' => '',
        ],
    ],
    'subscriptions' => [
        [
            'element' => 'input',
            'type' => 'text',
            'name' => 'name',
            'label' => 'Название',
            'required' => true,
            'readonly' => false,
            'value' => '',
        ],
        [
            'element' => 'textarea',
            'type' => 'textarea',
            'name' => 'description',
            'label' => 'Описание',
            'required' => true,
            'readonly' => false,
            'value' => '',
        ],
        [
            'element' => 'input-number',
            'type' => 'number',
            'name' => 'calls',
            'label' => 'Звонки',
            'required' => true,
            'readonly' => false,
            'value' => '',
            'max' => '',
            'min' => '0',
            'step' => '1'
        ],
        [
            'element' => 'input-number',
            'type' => 'number',
            'name' => 'amount',
            'label' => 'Стоимость',
            'required' => true,
            'readonly' => false,
            'value' => '',
            'max' => '',
            'min' => '0',
            'step' => '0.01'
        ],
        [
            'element' => 'input-number',
            'type' => 'number',
            'name' => 'period_in_months',
            'label' => 'Срок (в месяцах)',
            'required' => true,
            'readonly' => false,
            'value' => '',
            'max' => '',
            'min' => '0',
            'step' => '1'
        ],
        [
            'element' => 'multiple',
            'type' => 'multiple',
            'name' => 'courses',
            'label' => 'Курсы',
            'relation' => App\Models\Course::class,
            'multiple' => ['value' => 'id', 'label' => 'name', 'active' => 'visible'],
            'options' => []
        ],
        [
            'element' => 'checkbox',
            'type' => 'checkbox',
            'name' => 'active',
            'label' => 'Активен',
            'required' => false,
            'readonly' => false,
            'value' => '1',
        ],
    ],
    'topics' => [
        [
            'element' => 'input',
            'type' => 'text',
            'name' => 'name',
            'label' => 'Название',
            'required' => true,
            'readonly' => false,
            'value' => '',
        ],
        [
            'element' => 'input-img',
            'type' => 'file',
            'accept' => 'image/png, image/jpeg',
            'name' => 'img',
            'label' => 'Изображение',
            'required' => false,
            'readonly' => false,
            'value' => '',
        ],
        [
            'element' => 'multiple',
            'type' => 'multiple',
            'name' => 'words',
            'label' => 'Слова',
            'relation' => App\Models\Word::class,
            'multiple' => ['value' => 'id', 'label' => 'text', 'active' => ''],
            'options' => []
        ],
        [
            'element' => 'checkbox',
            'type' => 'checkbox',
            'name' => 'active',
            'label' => 'Активен',
            'required' => false,
            'readonly' => false,
            'value' => '1',
        ],
    ],
    'constants' => [
        [
            'element' => 'input',
            'type' => 'email',
            'name' => 'feedback_email',
            'label' => 'Email для обратной связи',
            'required' => true,
            'readonly' => false,
            'value' => '',
        ],
        [
            'element' => 'input-number',
            'type' => 'number',
            'name' => 'trial_amount',
            'label' => 'Сумма пробного платежа',
            'required' => true,
            'readonly' => false,
            'value' => '',
            'max' => '',
            'min' => '1',
            'step' => '0.01'
        ],
        [
            'element' => 'input-number',
            'type' => 'number',
            'name' => 'call_amount',
            'label' => 'Стоимость одного звонка',
            'required' => true,
            'readonly' => false,
            'value' => '',
            'max' => '',
            'min' => '1',
            'step' => '0.01'
        ],
        [
            'element' => 'input-number',
            'type' => 'number',
            'name' => 'repeat_train_v',
            'label' => 'Число повторений слова в тесте типа Выбор жеста',
            'required' => true,
            'readonly' => false,
            'value' => '',
            'max' => '',
            'min' => '1',
            'step' => '1'
        ],
        [
            'element' => 'input-number',
            'type' => 'number',
            'name' => 'repeat_train_r',
            'label' => 'Число повторений слова в тесте типа Выбор региона',
            'required' => true,
            'readonly' => false,
            'value' => '',
            'max' => '',
            'min' => '1',
            'step' => '1'
        ],
        [
            'element' => 'input-number',
            'type' => 'number',
            'name' => 'repeat_train_w',
            'label' => 'Число повторений слова в тесте типа Выбор слова',
            'required' => true,
            'readonly' => false,
            'value' => '',
            'max' => '',
            'min' => '1',
            'step' => '1'
        ],
    ],
    'regions' => [
        [
            'element' => 'input',
            'type' => 'text',
            'name' => 'name',
            'label' => 'Название',
            'required' => true,
            'readonly' => false,
            'value' => '',
        ],
        [
            'element' => 'input',
            'type' => 'text',
            'name' => 'in_name',
            'label' => 'Название в предложном падеже',
            'required' => true,
            'readonly' => false,
            'value' => '',
        ],
        [
            'element' => 'map',
            'type' => 'text',
            'name' => 'map',
            'label' => 'Координаты',
            'required' => true,
            'readonly' => false,
            'value' => '',
            'input_latitude' => 'latitude',
            'input_longitude' => 'longitude',
            'value_latitude' => '',
            'value_longitude' => '',
        ],
    ]
];

/*
[
            'element' => '',
            'type' => '',
            'name' => '',
            'label' => '',
            'required' => false,
            'readonly' => false,
            'value' => '',
        ],
 */