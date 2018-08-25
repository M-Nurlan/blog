<?php
namespace app\rbacrules;

use yii\rbac\Rule;

class UserRule extends Rule
{
    public $name = 'isUser';
    
    public function execute($user_id, $item, $params)
    {
        if (isset($params['user_id']) && ($params['user_id'] === $user_id)) return true;
        return false;
    }
}

?>