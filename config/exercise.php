<?php

return [
    /*
     * Company symbols json file url
     */
    'json_url' => env('COMPANY_SYMBOL_JSON_FILE', ''),

    /*
     * RapidAPI endpoint url
     */
    'endpoint' => env('RAPID_API_ENDPOINT', ''),
    'apikey' => env('RAPID_API_KEY', ''),
    'x-api-host' => env('X_RapidAPI_Host', ''),
];