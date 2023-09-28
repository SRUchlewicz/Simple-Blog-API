<?php

return [
    'reset_password_token_ttl' => env('RESET_PASSWORD_TOKEN_TTL', 10),
    'allowed_roles_for_login' => explode(',', env('ALLOWED_ROLES_FOR_LOGIN', 'editor,admin')),
    'posts_per_page' => env('NUMBER_OF_POSTS_PER_PAGE', 10)
];
