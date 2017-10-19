<?php
return [
    'USER_STATUS_NONE'                 => 0,    // 仮登録
    'USER_STATUS_REGIST'               => 1,    // 通常の会員
    'USER_STATUS_STOP'                 => 2,    // 会員登録したが何らかの理由で退会せず、機能を利用させない状態
    'USER_STATUS_VOLUNTARY_WITHDRAWAL' => 8,    // 会員自ら退会
    'USER_STATUS_FORCED_WITHDRAWAL'    => 9,    // 運営側が強制的に退会

    'USER_STATUS_LIST' => [
        '0' => '仮登録',
        '1' => '通常',
        '9' => '強制退会',
    ],

    // 認証メール期限(日数指定)
    'USER_VERIFY_DAY'  => 7,

    'USER_VERIFY_STATUS_NG' => 0,
    'USER_VERIFY_STATUS_OK' => 1,
];