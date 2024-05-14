<?php

namespace App\Helpers;

class RedirectHelper{
    public static function routeBackWithErrors(array $data){
        return back()->withErrors($data);
    }

    public static function routeBack($route = '', $class, $title, $mode = ''){
        $title = strtolower($title);

        if($mode == "create"){
            $modeMessage = "creating new $title";
        }
        elseif($mode == "update"){
            $modeMessage = "changes to $title";
        }
        elseif($mode == "delete"){
            $modeMessage = "deletes to $title";
        }
        elseif($mode == "register"){
            $modeMessage = "user registration";
            
            $guide = "Please check your email to verify your account.";
        }
        elseif($mode == "recover"){
            $modeMessage = "account recovery";

            $guide = "Please check your email to to continue with the next step.";
        }
        elseif($mode == "reset"){
            $modeMessage = "password reset";

            $guide = "Now you can authenticate using the new credentials.";
        }
        elseif($mode == "verify"){
            $modeMessage = "email verification";

            $guide = "Thank you and enjoy the additional features.";
        }
        elseif($mode == "decision"){
            $modeMessage = "making decision for $title";
        }
        else{
            $modeMessage = "$title";
        }

        if(isset($guide)){
            $message = "Your action in $modeMessage was successful. $guide";
        }
        else{
            $message = "Your action in $modeMessage was successful.";
        }

        if($route == null){
            return back()->with("class", $class)->with("message", $message);
        }
        else{
            return redirect()->route($route)->with("class", $class)->with("message", $message);
        }
    }

    public static function routeIntended($route){
        return redirect()->intended(route($route));
    }
}