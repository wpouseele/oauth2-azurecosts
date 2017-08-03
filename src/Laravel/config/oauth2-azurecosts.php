<?php

return [
    'clientId' => getenv('AZURECOSTS_CLIENT_ID'),
    'clientSecret' => getenv('AZURECOSTS_CLIENT_SECRET'),
    'redirectUri' => getenv("AZURECOSTS_REDIRECT_URI")
];