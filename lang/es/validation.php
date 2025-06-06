<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Validación del idioma
    |--------------------------------------------------------------------------
    |
    | Las siguientes líneas de idioma contienen los mensajes de error predeterminados utilizados por
    | La clase validadora. Algunas de estas reglas tienen múltiples versiones tales
    | como las reglas de tamaño. Siéntase libre de modificar cada uno de estos mensajes aquí.
    |
    */

    'accepted' => 'El campo debe ser aceptado.',
    'accepted_if' => 'El campo debe ser aceptado cuando :other es :value.',
    'active_url' => 'El campo no es una URL válida.',
    'after' => 'El campo debe ser una fecha posterior a :date.',
    'after_or_equal' => 'El campo debe ser una fecha posterior o igual a :date.',
    'alpha' => 'El campo sólo puede contener letras.',
    'alpha_dash' => 'El campo sólo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num' => 'El campo sólo puede contener letras y números.',
    'array' => 'El campo debe ser un arreglo.',
    'ascii' => 'El solo debe contener símbolos y caracteres alfanuméricos de un solo byte.',
    'before' => 'El campo debe ser una fecha anterior a :date.',
    'before_or_equal' => 'El campo debe ser una fecha anterior o igual a :date.',
    'between' => [
        'array' => 'El campo debe tener entre :min y :max elementos.',
        'file' => 'El campo debe tener entre :min y :max kilobytes.',
        'numeric' => 'El campo debe estar entre :min y :max.',
        'string' => 'El campo debe tener entre :min y :max caracteres.',
    ],
    'boolean' => 'El campo debe ser verdadero o falso.',
    'can' => 'El campo contiene un valor no autorizado.',
    'confirmed' => 'El campo de confirmación de no coincide.',
    'current_password' => 'La contraseña actual no es correcta',
    'date' => 'El campo no es una fecha válida.',
    'date_equals' => 'El campo debe ser una fecha igual a :date.',
    'date_format' => 'El campo no corresponde con el formato :format.',
    'decimal' => 'El debe tener :decimal decimales.',
    'declined' => 'El campo debe de ser rechazado.',
    'declined_if' => 'El campo debe ser rechazado cuando :other es :value.',
    'different' => 'Los campos y :other deben ser diferentes.',
    'digits' => 'El campo debe tener :digits dígitos.',
    'digits_between' => 'El campo debe tener entre :min y :max dígitos.',
    'dimensions' => 'El campo tiene dimensiones de imagen inválidas.',
    'distinct' => 'El campo tiene un valor duplicado.',
    'doesnt_end_with' => 'El campo no puede finalizar con uno de los siguientes valores: :values.',
    'doesnt_start_with' => 'El campo no puede comenzar con uno de los siguientes valores: :values.',
    'email' => 'El formato del no es válido.',
    'ends_with' => 'El campo debe terminar con alguno de los valores: :values.',
    'enum' => 'El valor seleccionado no es válido.',
    'exists' => 'El valor seleccionado no es válido.',
    'extensions' => 'El campo debe tener una de las siguientes extensiones: :values.',
    'file' => 'El campo debe ser un archivo.',
    'filled' => 'El campo debe tener un valor.',
    'gt' => [
        'array' => 'El campo debe tener mas de :value elementos.',
        'file' => 'El campo debe ser mayor que :value kilobytes.',
        'numeric' => 'El campo debe ser mayor que :value.',
        'string' => 'El campo debe ser mayor a :value caracteres.',
    ],
    'gte' => [
        'array' => 'El campo debe tener :value elementos o más.',
        'file' => 'El campo debe ser mayor o igual que :value kilobytes.',
        'numeric' => 'El campo debe ser mayor o igual que :value.',
        'string' => 'El campo debe ser mayor o igual a :value caracteres.',
    ],
    'hex_color' => 'El campo debe tener un color hexadecimal válido.',
    'image' => 'El campo debe ser una imagen.',
    'in' => 'El campo seleccionado no es válido.',
    'in_array' => 'El campo no existe en :other.',
    'integer' => 'El campo debe ser un entero.',
    'ip' => 'El campo debe ser una dirección IP válida.',
    'ipv4' => 'El campo debe ser una dirección IPv4 válida.',
    'ipv6' => 'El campo debe ser una dirección IPv6 válida.',
    'json' => 'El campo debe ser una cadena JSON válida.',
    'lowercase' => 'El debe estar en minúsculas.',
    'lt' => [
        'array' => 'El campo puede tener menos de :max elementos.',
        'file' => 'El campo debe ser menor de :max kilobytes.',
        'numeric' => 'El campo debe ser menor que :max.',
        'string' => 'El campo debe ser menor de :max caracteres.',
    ],
    'lte' => [
        'array' => 'El campo no puede tener más de :max elementos.',
        'file' => 'El campo debe ser menor o igual que :max kilobytes.',
        'numeric' => 'El campo debe ser menor o igual que :max.',
        'string' => 'El campo debe ser menor o igual que :max caracteres.',
    ],
    'mac_address' => 'El campo debe ser una dirección MAC válida.',
    'max' => [
        'array' => 'El campo puede tener hasta :max elementos.',
        'file' => 'El campo no puede pasar los :max kilobytes.',
        'numeric' => 'El campo no debe de ser mayor a :max.',
        'string' => 'El campo debe ser menor que :max caracteres.',
    ],
    'max_digits' => 'El campo no debe de tener mas de :max dígitos.',
    'mimes' => 'El campo debe ser un archivo de tipo: :values.',
    'mimetypes' => 'El campo debe ser un archivo de tipo: :values.',
    'min' => [
        'array' => 'El campo debe tener al menos :min elementos.',
        'file' => 'El campo debe tener al menos :min kilobytes.',
        'numeric' => 'El campo debe tener al menos :min.',
        'string' => 'El campo debe tener al menos :min caracteres.',
    ],
    'min_digits' => 'El campo debe ser como mínimo de :min dígitos.',
    'missing' => 'El campo debe faltar.',
    'missing_if' => 'El campo debe faltar cuando :other es :value',
    'missing_unless' => 'El campo debe faltar a menos que :other sea :value.',
    'missing_with' => 'El campo debe faltar cuando :values está presente.',
    'missing_with_all' => 'El campo debe faltar cuando :values están presentes',
    'multiple_of' => 'El campo debe ser un múltiplo de :value.',
    'not_in' => 'El valor seleccionado no es válido.',
    'not_regex' => 'El formato del campo no es válido.',
    'numeric' => 'El campo debe ser un número.',
    'password' => [
        'letters' => 'El campo debe contener al menos una letra.',
        'mixed' => 'El campo debe contener al menos una letra mayúscula y una minúscula.',
        'numbers' => 'El campo debe contener al menos un número.',
        'symbols' => 'El campo debe contener al menos un símbolo.',
        'uncompromised' => 'El valor del campo aparece en alguna filtración de datos. Por favor indica un valor diferente.',
    ],
    'present' => 'El campo debe estar presente.',
    'present_if' => 'El campo debe estar presente cuando el campo :other es :value.',
    'present_unless' => 'El campo debe estar presenta a no ser que el campo :other sea :value.',
    'present_with' => 'El campo debe estar presente cuando :values está presente.',
    'present_with_all' => 'El campo debe estar presente cuando :values están presentes.',
    'prohibited' => 'El campo no está permitido.',
    'prohibited_if' => 'El campo no está permitido cuando :other es :value.',
    'prohibited_unless' => 'El campo no está permitido si :other no está en :values.',
    'prohibits' => 'El campo no permite que :other esté presente.',
    'regex' => 'El formato del campo no es válido.',
    'required' => 'El campo es requerido.',
    'required_array_keys' => 'El campo debe contener entradas para: :values.',
    'required_if' => 'El campo es requerido cuando el campo :other es :value.',
    'required_if_accepted' => 'El campo es requerido cuando el campo :other es aceptado.',
    'required_unless' => 'El campo es requerido a menos que :other esté presente en :values.',
    'required_with' => 'El campo es requerido cuando :values está presente.',
    'required_with_all' => 'El campo es requerido cuando :values están presentes.',
    'required_without' => 'El campo es requerido cuando :values no está presente.',
    'required_without_all' => 'El campo es requerido cuando ninguno de los valores :values está presente.',
    'same' => 'El campo debe coincidir con :other.',
    'size' => [
        'array' => 'El campo debe contener :size elementos.',
        'file' => 'El campo debe tener :size kilobytes.',
        'numeric' => 'El campo debe ser :size.',
        'string' => 'El campo debe tener :size caracteres.',
    ],
    'starts_with' => 'El debe empezar con uno de los siguientes valores :values',
    'string' => 'El campo debe ser una cadena.',
    'timezone' => 'El campo debe ser una zona horaria válida.',
    'unique' => 'El ya existe.',
    'uploaded' => 'El campo no ha podido ser cargado.',
    'uppercase' => 'El debe estar en mayúsculas',
    'url' => 'El formato de no es válido.',
    'ulid' => 'El debe ser un ULID valido.',
    'uuid' => 'El debe ser un UUID valido.',

    /*
    |--------------------------------------------------------------------------
    | Validación del idioma personalizado
    |--------------------------------------------------------------------------
    |
    | Aquí puede especificar mensajes de validación personalizados para atributos utilizando el
    | convención "attribute.rule" para nombrar las líneas. Esto hace que sea rápido
    | especifique una línea de idioma personalizada específica para una regla de atributo dada.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Atributos de validación personalizados
    |--------------------------------------------------------------------------
    |
    | Las siguientes líneas de idioma se utilizan para intercambiar los marcadores de posición de atributo.
    | con algo más fácil de leer, como la dirección de correo electrónico.
    | de "email". Esto simplemente nos ayuda a hacer los mensajes un poco más limpios.
    |
    */

    'attributes' => [],

];
