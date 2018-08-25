<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        
        // add "createPost" permission
        $create = $auth->createPermission('create');
        $create->description = 'Create a post';
        $auth->add($create);

        // add "updatePost" permission
        $update = $auth->createPermission('update');
        $update->description = 'Update post';
        $auth->add($update);

        $delete = $auth->createPermission('delete');
        $delete->description = 'Delete post';
        $auth->add($delete);

        // add "author" role and give this role the "createPost" permission
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $create);

        $moderator = $auth->createRole('moderator');
        $auth->add($moderator);
        $auth->addChild($moderator, $user);
        $auth->addChild($moderator, $update);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $update);
        $auth->addChild($admin, $delete);
        $auth->addChild($admin, $user);

        // add the rule
        $rule = new \app\rbacrules\UserRule;
        $auth->add($rule);

        // добавляем право "updateOwnPost" и связываем правило с ним
		$updateOwn = $auth->createPermission('updateOwn');
		$updateOwn->description = 'Update own articles';
		$updateOwn->ruleName = $rule->name;
		$auth->add($updateOwn);
		$auth->addChild($updateOwn, $update);
		$auth->addChild($user, $updateOwn);
		// "updateOwnPost" наследует право "updatePost"
		// $update = Yii::$app->authManager->getPermission('update');
		
		 
		//$user = Yii::$app->authManager->getRole('user');
		// и тут мы позволяем автору редактировать свои посты

		$deleteOwn = $auth->createPermission('deleteOwn');
		$deleteOwn->description = 'delete own articles';
		$deleteOwn->ruleName = $rule->name;
		$auth->add($deleteOwn);
		$auth->addChild($deleteOwn, $delete);
		$auth->addChild($user, $deleteOwn);
		 
		// "updateOwnPost" наследует право "updatePost"
		//$delete = Yii::$app->authManager->getPermission('delete');
		 
		//$user = Yii::$app->authManager->getRole('user');
		// и тут мы позволяем автору редактировать свои посты

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($user, 40);
        $auth->assign($admin, 1);
        $auth->assign($moderator, 3);

    }
}