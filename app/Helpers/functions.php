<?php
/*
[
    'success'=>[podaci] ili
    'errors'=>[greške],
], $code



{
    "message": "The given data was invalid.",
    "errors": {
        "title": [
            "obavezno"
        ],
        "body": [
            "The body field is required."
        ]
    }
}
 */


function errorResponse(array $data, $code, $message=null){
    $arr_to_be_returned=['errors'=>$data, 'code'=>$code];
    if($message){
        $arr_to_be_returned['message']=$message;
    }
    return json_decode(json_encode(['response'=>$arr_to_be_returned]));
}


function successResponse($data, $code, $message=null){
    $arr_to_be_returned=['success'=>$data, 'code'=>$code];
    if($message){
        $arr_to_be_returned['message']=$message;
    }
    //return json_decode(json_encode(['data'=>$arr_to_be_returned]));
    return ['response'=>$arr_to_be_returned];
}



