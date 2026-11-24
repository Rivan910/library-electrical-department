<?php

return [

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google_sheets' => [
        'spreadsheet_id' => env('GOOGLE_SHEETS_SPREADSHEET_ID'),

        'credentials_path' => base_path(
            env(
                'GOOGLE_SERVICE_ACCOUNT_PATH',
                'storage/app/google/service-account.json'
            )
        ),

        'library_tab' => env(
            'GOOGLE_SHEETS_LIBRARY_TAB',
            'library'
        ),

        'sync_id_prefix' => env(
            'GOOGLE_SHEETS_SYNC_ID_PREFIX',
            'STOCK'
        ),
    ],

    'fonnte' => [
        'token' => env('FONNTE_TOKEN'),
        'target' => env('FONNTE_TARGET'),
    ],

];