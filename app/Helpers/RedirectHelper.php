<?php

namespace App\Helpers;

class RedirectHelper{
    public static function routeBack($route = '', $class, $title, $mode = ''){
        $title = strtolower($title);

        if($mode == "create"){
            $modeState = "new $title";
        }
        elseif($mode == "update"){
            $modeState = "changes to $title";
        }
        elseif($mode == "delete"){
            $modeState = "deletes to $title";
        }
        else{
            $modeState = "actions to $title";
        }

        $message = "Your $modeState is recorded successfully. Thank you.";

        if($route == null){
            return back()->with('class', $class)->with('message', $message);
        }
        else{
            return redirect()->route($route)->with('class', $class)->with('message', $message);
        }
    }
}