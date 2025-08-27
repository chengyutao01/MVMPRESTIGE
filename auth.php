<?php
namespace classes;


use Symfony\Component\HttpFoundation\Session\Session;
use classes\Models\User;



class Auth {

const Root = 0;
const Admin = 1;
const Operator1 = 2;
const Operator2 = 3;


    public static function Authenticate($user, $password){

        if (count($user)  > 0 && password_verify($password, $user[0]->password) ){
            return true;
        } 
        return false;
    }

    public static function isLogged($session){
        if ($session->has('user.id')){
            return true;
        }
        return false;   
    }
    public static function isRoot($session){
        if ($session->get('user.role', 1000) == 0){
            return true;
        }
        return false;   
    }
    public static function isAdmin($session){
        if ($session->get('user.role', 1000) == 1){
            return true;
        }
        return false;   
    }
    public static function isAdminAtLeast($session){
        if ($session->get('user.role', 1000) <= 1){
            return true;
        }
        return false;   
    }
    public static function isOperator1($session){
        if ($session->get('user.role', 1000) == 2){
            return true;
        }
        return false;   
    }
    public static function isOperator1AtLeast($session){
        if ($session->get('user.role', 1000) <= 2){
            return true;
        }
        return false;   
    }
    public static function isOperator2($session){
        if ($session->get('user.role', 1000) == 3){
            return true;
        }
        return false;   
    }


}
