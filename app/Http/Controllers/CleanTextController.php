<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CleanTextController extends Controller
{
    public function ReplaceScriptWithPTag($string){
        $firsString = str_replace('&lt;script&gt;','<p>',$string);
        $cleanString = str_replace('&lt;/script&gt;','</p>',$firsString);
        return $cleanString;
    }//end method



    public function CleanScript($string){
        $firsString = str_replace('<script>','',$string);
        $cleanString = str_replace('</script>','',$firsString);
        return $cleanString;
    }//end method




}
