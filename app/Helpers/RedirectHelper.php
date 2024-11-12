<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class RedirectHelper{
    public static function routeBackWithErrors(array $data){
        return back()->withErrors($data);
    }

    public static function routeBack($route = null, $class, $title, $mode = null){
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
        elseif($mode == "follow"){
            $modeMessage = "following " . Str::of($title)->apa();
        }
        elseif($mode == "unfollow"){
            $modeMessage = "unfollowing " . Str::of($title)->apa();
        }
        elseif($mode == "register"){
            $modeMessage = "user registration";
            
            $guide = "Please check your email to verify your account.";
        }
        elseif($mode == "recover"){
            $modeMessage = "account recovery";

            $guide = "Please check your email to to continue with the next step regarding account recover.";
        }
        elseif($mode == "claim"){
            $modeMessage = "account claim";

            $guide = "Please check your email to to continue with the next step regarding account claim.";
        }
        elseif($mode == "reset"){
            $modeMessage = "password reset";

            $guide = "Now you can authenticate using the new credentials.";
        }
        elseif($mode == "verify"){
            $modeMessage = "verification";

            $guide = "Thank you and enjoy the additional features.";
        }
        elseif($mode == "decision"){
            $modeMessage = "making decision for $title";
        }
        elseif($mode == "error"){
            $modeMessage = "error";
        }
        else{
            $modeMessage = "$title";
        }

        if($mode && isset($guide)){
            $message = "Your action in $modeMessage was successful. $guide";
        }
        elseif($mode == "error" && !isset($guide)){
            $str = Str::of($title);

            $before = $str->before('.');

            $after = $str->after('.');

            if($before && !$after){
                $message = "Your action in $before was unsuccessful.";
            }
            else{
                $message = "Your action in $before was unsuccessful, $after";
            }
        }
        else{
            $message = "Your action in $modeMessage was successful.";
        }

        if($route !== null && is_array($route) == false){
            return redirect()->route($route)->with("class", $class)->with("message", $message);
        }
        elseif($route !== null && is_array($route) == true){
            return redirect()->route($route['route'], (isset($route['query']) ? $route['query'] : null))->with("class", $class)->with("message", $message);
        }
        else{
            return back()->with("class", $class)->with("message", $message);
        }
    }

    public static function routeIntended($route){
        return redirect()->intended($route);
    }
}