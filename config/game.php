<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Game API limits
    |--------------------------------------------------------------------------
    |
    | Maximum values accepted per call to POST /api/update-score-coins.
    | The endpoint adds these deltas to the player's totals, so they must be
    | non-negative and bounded.
    |
    */

    'max_score_delta' => (int) env('GAME_MAX_SCORE_DELTA', 100000),
    'max_coin_delta' => (int) env('GAME_MAX_COIN_DELTA', 10000),
    'max_retry_delta' => (int) env('GAME_MAX_RETRY_DELTA', 100),

];
