Codeigniter2-Doctrine2-Twig-Composer
====================================

REQUIREMENTS:

php 5.3 or best, Database management (mysql, pgsql, sqlite, oracle, sqlserver), apache2

THE BEST REASONS TO USE THIS:

This is a Codeigniter 2.1.3 with Doctrine2 ORM, Twig, and Composer integration.
I was add two libraries in application/libraries/ called Doctrine.php and Twig.php both libraries are autoloaded in application/autoload;


It's great work with Netbeans 7.2 or best because it's have integrated doctrine2 ORM command

----- http://netbeans.org/kb/docs/php/screencast-doctrine2.html

-> so you can run commands like schema:create or update, generate:entities, generate:repository, etc

-> in our application we found application/models/Entity and application/models/Repository to store database management entities
    in our proyect we have cli-config.php it's necesary to load the commands in doctrine2
    
----- http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/index.html

It's greate because the most popular Twig is integrated with this, and some helper extension 

----- http://twig.sensiolabs.org/

-> application/core/Twig/Core_Twig_Extension.php this will help to register helper functions, globals vars, filters, etc in twig.


It's greate because this use a Composer repository management

----- http://getcomposer.org/doc/00-intro.md

-> inside our proyect we found composer.json

WE STARTED WITH AN SHORT DINAMMIC APPLICATION, WITH AND EXAMPLE HOW WORK IT PERFECTLY 
application/controller/guest.php
application/controller/user.php
