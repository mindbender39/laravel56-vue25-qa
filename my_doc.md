Date Started: 17-09-2019
Version: Laravel 5.6
------------------
Help:
------------------
- Listing All Available Commands
    php artisan list

- Create custom class:
    - Create Custom directory (or other custom class) file and give it a matching namespace.
    - Create an alias within config/app.php
    - Use it in Blade template:
        - {!! Helper::getFullName('john', 'butler') !!}
    - Use it in anywhere in the app like:
        - class SomeController extends Controller
          {
              protected $full_name;
              public function __construct() {
                  $this->full_name = Helper::getFullName('john', 'butler');
              }
          }

- Composer: A composer or view composer is used to binding an event to view when its loaded.
  It allow us to add data to a view whenever its called.
  - Create a folder in app/View/Composer
  - Add file and register it in app/Providers/AppServiceProvider.php inside boot function

- view routes:
    - php artisan route:list
    - to view specific route use its name
        - php artisan route:list --name=questions
------------------------------------------------------------------------------------------
01: Installing Laravel
    - Using composer run the following command by starting composer cmd in wamp/www
    - command: composer create-project laravel/laravel blog "5.6.*" (version: if specific)
    - Skip public dir from url by creating .htaccess file using following code:
        - To remove public from URL:
        - change server.php to index.php in root

        RewriteEngine On

        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)/$ /$1 [L,R=301]

        RewriteCond %{REQUEST_URI} !(\.css|\.js|\.png|\.jpg|\.gif|robots\.txt)$ [NC]
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^ index.php [L]

        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_URI} !^/public/
        RewriteRule ^(css|js|images)/(.*)$ public/$1/$2 [L,NC]

OR
    <IfModule mod_rewrite.c>
    RewriteEngine On

    RewriteCond %{REQUEST_URI} !^public
    RewriteRule ^(.*)$ public/$1 [L]
    </IfModule>

02: Create Database and change db info in .env file

03: Change app name using command: php artisan app:name MyApp

04: Crate Database Tables using migration
    - php artisan migrate:install (it will create migration table in db)
    - run command to create migration table:
        php artisan make:migration --create pages create_pages_table
            - it will create a file in database/migration folder where we can add more columns for our
              table and then run command: php artisan migrate. to create table in db.
    - Next we create a seeder class in database/seeds folder to seed user table with some data
    - First we create a seed class by running command: php artisan make:seeder UserTableSeeder
    - Then call our seeder class in DatabaseSeeder class and run following command to seed db.
        php artisan db:seed
    - To run specific migration then create a folder inside migrations folder and
      use the following command, in that way old migrations won't run.
      php artisan migrate --path=/database/migrations/temp

--------------------------------------------------------------------------------------------------
05: Create Controller:
   - To create controller use command: php artisan make:controller NameofController (simple controller)
   - or to create RESTful controller use command: php artisan make:controller NameofController --resource
   - or to create RESTful controller with model reference use command: php artisan make:controller NameofController --resource --model=ModelName
     - It will create a controller with the given name with some actions/functions
     - To skip an action use: php artisan make:controller NameofController --except=show

06: Auth Boilerplate
   - run command php artisan make:auth
   - the above command will generate all related views for the existing User controller, model and migrations

07: Create Model with migration
   - run command php artisan make:model YourModelName -m
   - the above command will create a model class with the migration
   - To re-build database with seed data: php artisan migrate:fresh --seed

08: Seed Database
   - Create seeder class using command: php artisan make:seed NameOfSeederClass
     After saving the changes in seeder class use composer dump-autoload to rebuild the classmap
   - To seed database use php artisan db:seed
   - To seed specific seeder class: php artisan db:seed --class=UsersTableSeeder
   
09: To Remove a composer package:
    - use command: composer remove illuminate/html

10: From Laravel 5.3 >= we can customize pagination
    - php artisan vendor:publish --tag=laravel-pagination
    - in views/vendor/pagination directory will be create and there we can modify/redesign

--------------------------------------------
Working with Git steps:
1: From project directory run command: git init
2: git add .
3: git commit -m "Initial Commit"
4: create a repository on Git account
5: then push locally created repo. to remote:
    - git remote add origin https://github.com/mindbender39/laravel56-vue25-qa.git
6: git push -u origin master
7: to check status to see if we made any change
    - git status
8: if any change found then add those changes/files
    - git add .
    - git commit -m "your comments"
    - git push origin master
9:  to find out in which branch we are standing right now
    - git branch 
10: before starting new lesson we will create a new branch locally and merge it with master when we done.
    - git checkout -b yourBranchName
11: after completing lesson we will repeat step 2 and 3 then push our new branch
    - git push origin yourBranchName
12: switch back to master branch
    - git checkout master
    - git merge yourBranchName





