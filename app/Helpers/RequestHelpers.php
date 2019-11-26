<?php

use Illuminate\Http\Request;

if (!function_exists('convertRequestBodyToArray')) {
    function convertRequestBodyToArray(Request $request)
    {
        $string = $request->getContent();
        $values = json_decode($string, true);
        if (!isset($values['created_at']))
            $values['created_at'] = date_create()->format('Y-m-d H:i:s');
        if (!isset($values['updated_at']))
            $values['updated_at'] = date_create()->format('Y-m-d H:i:s');
        return $values;
    }
}
if (!function_exists('responseSuccess')) {
    function responseSuccess($message = '')
    {
        return response(
            [
                "status" => "success",
                "message" => $message
            ]);
    }
}
if (!function_exists('responseFail')) {
    function responseFail($message)
    {

        return response(
            [
                "status" => "fail",
                "message" => $message
            ]);

    }
}