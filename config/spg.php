<?php
return [
  'spg_default_auth' => [
    'spg_user' => env('SPG_USER'),
    'spg_password' => env('SPG_PASSWORD'),
  ],
  'spg_paid_auth' => [
    'spg_user' => env('SPG_PAID_USER'),
    'spg_password' => env('SPG_PAID_PASSWORD'),
    'spg_account' => env('SPG_PAID_ACCOUNT'),
  ]
];
