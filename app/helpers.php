<?php

use Illuminate\Support\Facades\Crypt;

function encryptData($string){
    return Crypt::encryptString($string);
}
function decryptData($encodedString){
    return Crypt::decryptString($encodedString);
}