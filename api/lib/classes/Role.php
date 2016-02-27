<?php
function hasPerm($module,$permission)
{
    $user_type  = current_user_type();
    $role = particular_detail($user_type,'roles','role','id');
    $permissions = particular_detail($role,'permisions','role','permission');
    $arr_permissions = json_decode($permissions,true);
    
    if(isset($arr_permissions[$module]) || array_key_exists($module,$arr_permissions==null?array():$arr_permissions))
    {
        if(isset($arr_permissions[$module][$permission]) || array_key_exists($permission,$arr_permissions[$module]==null?array():$arr_permissions[$module])):
            return true;
        else:
            return false;
        endif;
    }
    else
    {
        return false;
    }
    
}

function hasModulePermission($module)
{
    $user_type  = current_user_type();
    $role = particular_detail($user_type,'roles','role','id');
    $permissions = particular_detail($role,'permisions','role','permission');
    $arr_permissions = json_decode($permissions,true);
    if(isset($arr_permissions[$module]) || array_key_exists($module,$arr_permissions==null?array():$arr_permissions))
    {
        return true;
    }else{
        return false;
    }
}
