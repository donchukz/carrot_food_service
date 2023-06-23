<?php

namespace App\Traits;

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait ApiResponser
{

    /**
     * Return a success JSON response.
     *
     * @param  array|string  $data
     * @param  string  $message
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data, string $message = 'Your action has been processed.', int $code = 200)
    {
        return response()->json([
            'api_status' => 'success',
            'api_message' => $message,
            'api_data' => $data
        ], $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  array|string|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error(string $message = 'The system is not able to process your request at the moment. Kindly try again later. Thank You!', int $code = 500, $data = [])
    {
        return response()->json([
            'api_status' => 'error',
            'api_message' => $message,
            'api_data' => $data
        ], $code);
    }

    public static function validatorFormatErrors($validator){
        $errors = json_decode($validator, true);
        $errorMessages['status'] = 'failed';
        $errorMessages['errors'] = collect($errors)->flatten()->values()->all();
        return $errorMessages;
    }
}
