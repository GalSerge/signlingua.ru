<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Языковые ресурсы для проверки значений
    |--------------------------------------------------------------------------
    |
    | Последующие языковые строки содержат сообщения по-умолчанию, используемые
    | классом, проверяющим значения (валидатором). Некоторые из правил имеют
    | несколько версий, например, size. Вы можете поменять их на любые
    | другие, которые лучше подходят для вашего приложения.
    |
    */

    'accepted'         => 'Вы должны принять :attribute.',
    'active_url'       => 'Поле недействительный URL.',
    'after'            => 'Поле должно быть датой после :date.',
    'alpha'            => 'Поле может содержать только буквы.',
    'alpha_dash'       => 'Поле может содержать только буквы, цифры и дефис.',
    'alpha_num'        => 'Поле может содержать только буквы и цифры.',
    'array'            => 'Поле должно быть массивом.',
    'before'           => 'Поле должно быть датой перед :date.',
    'between'          => [
        'numeric' => 'Поле должно быть между :min и :max.',
        'file'    => 'Размер должен быть от :min до :max Килобайт.',
        'string'  => 'Длина должна быть от :min до :max символов.',
        'array'   => 'Поле должно содержать :min - :max элементов.'
    ],
    'confirmed'        => 'Пароли не совпадают.',
    'current_password' => 'Пароль неверен.',
    'date'             => 'Поле не является датой.',
    'date_format'      => 'Поле не соответствует формату :format.',
    'different'        => 'Поля и :other должны различаться.',
    'digits'           => 'Длина цифрового поля должна быть :digits.',
    'digits_between'   => 'Длина цифрового поля должна быть между :min и :max.',
    'email'            => 'Поле имеет ошибочный формат.',
    'exists'           => 'Выбранное значение для уже существует.',
    'image'            => 'Поле должно быть изображением.',
    'in'               => 'Выбранное значение для ошибочно.',
    'integer'          => 'Поле должно быть целым числом.',
    'ip'               => 'Поле должно быть действительным IP-адресом.',
    'max'              => [
        'numeric' => 'Поле должно быть не больше :max.',
        'file'    => 'Поле должно быть не больше :max Килобайт.',
        'string'  => 'Поле должно быть не длиннее :max символов.',
        'array'   => 'Поле должно содержать не более :max элементов.'
    ],
    'mimes'            => 'Поле должно быть файлом одного из типов: :values.',
    'extensions'       => 'Поле должно иметь одно из расширений: :values.',
    'min'              => [
        'numeric' => 'Поле должно быть не менее :min.',
        'file'    => 'Поле должно быть не менее :min Килобайт.',
        'string'  => 'Поле должно быть не короче :min символов.',
        'array'   => 'Поле должно содержать не менее :min элементов.'
    ],
    'not_in'           => 'Выбранное значение для ошибочно.',
    'numeric'          => 'Поле должно быть числом.',
    'пароль' => [
        'letters' => 'Поле должно содержать хотя бы одну букву.',
        'mixed' => 'Поле должно содержать хотя бы одну прописную и одну строчную букву.',
        'numbers' => 'Поле должно содержать хотя бы одно число.',
        'symbols' => 'Поле должно содержать хотя бы один символ.',
        'uncompromised' => 'Данный пароль появился в результате утечки данных. Пожалуйста, выберите другой.',
    ],
    'regex'            => 'Поле имеет ошибочный формат.',
    'required'         => 'Поле обязательно для заполнения.',
    'required_if'      => 'Поле обязательно для заполнения, когда :other равно :value.',
    'required_with'    => 'Поле обязательно для заполнения, когда :values указано.',
    'required_without' => 'Поле обязательно для заполнения, когда :values не указано.',
    'same'             => 'Значение должно совпадать с :other.',
    'string'           => 'Поле должно быть строкой.',
    'size'             => [
        'numeric' => 'Поле должно быть :size.',
        'file'    => 'Поле должно быть :size Килобайт.',
        'string'  => 'Поле должно быть длиной :size символов.',
        'array'   => 'Количество элементов в поле должно быть :size.'
    ],
    'unique'           => 'Такое значение поля уже существует.',
    'url'              => 'Поле имеет ошибочный формат.',

    /*
    |--------------------------------------------------------------------------
    | Собственные языковые ресурсы для проверки значений
    |--------------------------------------------------------------------------
    |
    | Здесь Вы можете указать собственные сообщения для атрибутов, используя
    | соглашение именования строк 'attribute.rule'. Это позволяет легко указать
    | свое сообщение для заданного правила атрибута.
    |
    | http://laravel.com/docs/validation#custom-error-messages
    |
    */

    'custom' => [],

    /*
    |--------------------------------------------------------------------------
    | Собственные названия атрибутов
    |--------------------------------------------------------------------------
    |
    | Последующие строки используются для подмены программных имен элементов
    | пользовательского интерфейса на удобочитаемые. Например, вместо имени
    | поля 'email' в сообщениях будет выводиться 'электронный адрес'.
    |
    | Пример использования
    |
    |   'attributes' => array(
    |       'email' => 'электронный адрес',
    |   )
    |
    */

    'attributes' => [],

];