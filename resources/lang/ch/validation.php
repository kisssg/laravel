<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => '选项 :attribute 为必选',
    'active_url' => ':attribute 非有效链接',
    'after' => ':attribute 须晚于 :date.',
    'after_or_equal' => ':attribute 须晚于或等于 :date.',
    'alpha' => ':attribute 只能包含字母',
    'alpha_dash' => ':attribute 只能包含字母、数字、连字符或下划线',
    'alpha_num' => ':attribute 只能包含字母或数字',
    'array' => ':attribute 须为数组',
    'before' => ':attribute 须早于 :date.',
    'before_or_equal' => ':attribute 须早于或等于 :date.',
    'between' => [
        'numeric' => ':attribute 须介于 :min 和 :max.',
        'file' => ':attribute 须介于:min 到 :max KB',
        'string' => ':attribute 须介于 :min 到 :max 个字符',
        'array' => ':attribute 须包含 :min 到 :max 个元素',
    ],
    'boolean' => ':attribute 字段须为布尔值',
    'confirmed' => ':attribute 不匹配',
    'date' => ':attribute 非有效日期',
    'date_equals' => ':attribute 须等于 :date.',
    'date_format' => ':attribute 未满足限定格式 :format.',
    'different' => ':attribute 须不同于 :other ',
    'digits' => ':attribute 须为 :digits 位数字',
    'digits_between' => ' :attribute 须在 :min 位到 :max 位数字之间',
    'dimensions' => ':attribute 含无效的图像像素',
    'distinct' => ':attribute 包含重复值',
    'email' => ':attribute 须为有效邮件格式',
    'exists' => ':attribute 须为其中之一：:values',
    'file' => ':attribute 须为文件',
    'filled' => ':attribute 不能为空',
    'gt' => [
        'numeric' => ':attribute 须大于 :value.',
        'file' => ':attribute 须大于 :value KB',
        'string' => ':attribute 须大于 :value 个字符',
        'array' => ':attribute 须多于 :value 个元素',
    ],
    'gte' => [
        'numeric' => ':attribute 须大于或等于 :value.',
        'file' => ':attribute 须大于或等于 :value KB',
        'string' => ':attribute 须大于或等于 :value 个字符',
        'array' => ':attribute 不能少于 :value 个元素',
    ],
    'image' => ':attribute 须为图片',
    'in' => ' :attribute 须为其中之一： :values ',
    'in_array' => ':attribute 不存在于数组 :other.',
    'integer' => ':attribute 须为整数',
    'ip' => ':attribute 须为ip地址',
    'ipv4' => ':attribute 须为有效的 IPv4 地址',
    'ipv6' => ':attribute 须为有效的 IPv6 地址',
    'json' => ':attribute 须为有效的 JSON 字符',
    'lt' => [
        'numeric' => ':attribute 须小于 :value.',
        'file' => ':attribute 须小于 :value KB.',
        'string' => ':attribute 须少于 :value 个字符',
        'array' => ':attribute 须少于 :value 个元素',
    ],
    'lte' => [
        'numeric' => ':attribute 须小于或等于 :value.',
        'file' => ':attribute 须小于或等于 :value KB',
        'string' => ':attribute 须少于或等于 :value 个字符',
        'array' => ':attribute 须少于 :value 个字符',
    ],
    'max' => [
        'numeric' => ':attribute 不能大于 :max.',
        'file' => ':attribute 不能大于 :max KB',
        'string' => ':attribute 不能多于 :max 个字符',
        'array' => ':attribute 不能多于 :max 个字符',
    ],
    'mimes' => ':attribute 须为文件格式: :values.',
    'mimetypes' => ':attribute 须为文件格式: :values.',
    'min' => [
        'numeric' => ':attribute 不能小于 :min.',
        'file' => ':attribute 不能小于 :min KB',
        'string' => ':attribute 不能少于 :min 个字符',
        'array' => ':attribute 不能少于 :min 个元素',
    ],
    'not_in' => ':attribute 值不能为 :values',
    'not_regex' => ':attribute 格式不符合要求',
    'numeric' => ':attribute 须为数字',
    'present' => ':attribute 必须呈现',
    'regex' => ':attribute 格式不符合要求',
    'required' => ':attribute 为必填项',
    'required_if' => ':attribute 为必填若 :other 为 :value',
    'required_unless' => ':attribute 为必填，除非 :other 的值为 :values',
    'required_with' => '当 :values 存在时,:attribute 为必填',
    'required_with_all' => ':attribute 为必填，若 :values 都存在',
    'required_without' => ':attribute 为必填，若 :values 之一不存在',
    'required_without_all' => ':attribute 为必填，若 :values 都不存在',
    'same' => ':attribute 与 :other 必须匹配',
    'size' => [
        'numeric' => ':attribute 大小须为 :size',
        'file' => ':attribute 大小须为 :size KB',
        'string' => ':attribute 须为 :size 个字符',
        'array' => ':attribute 须包含:size 个元素',
    ],
    'starts_with' => ':attribute 的开头须为其中之一: :values',
    'string' => ':attribute 须为字符串',
    'timezone' => ':attribute 须为有效的时区',
    'unique' => ':attribute 已被占用',
    'uploaded' => ':attribute 上传失败',
    'url' => ':attribute 格式不对',
    'uuid' => ':attribute 须为有效的UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
