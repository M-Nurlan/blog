# Clone project via GIT
`git clone https://github.com/M-Nurlan/blog`

# For RBAC and others use migrations
`yii migrate`
`yii migrate --migrationPath=@yii/rbac/migrations/`

# Explanation
This is my project written using Yii2 framework for testing myself and it isn't finished yet. You can find rule `isUser` in `rbacrules` folder and RBAC controller in commands folder. To apply RBAC roles and permissions write `yii rbac/init` in console. I used DbManager and edited `web.php` and `console.php` adding into components:
```
'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
```
Also I've created signup, log in, account activation by e-mail, password resetting and if you logged in you can see `Forum` section on the nav-bar. This section is created by Gii module of Yii2 framework as CRUD. There you can create an article. As user you can create, read, update only your own articles and delete only your own articles. if you log in from another account you will see icons but you can't update and delete. As I said it's not finished and there is a lot of work to be done like admin panel, creating rules for other rules and etc.
