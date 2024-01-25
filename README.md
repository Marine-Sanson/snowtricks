# Snowtricks
Project for OpenClasssrooms : develop a website using Symfony

<div align="center">
    <br>
    <img src="https://upload.wikimedia.org/wikipedia/fr/0/0d/Logo_OpenClassrooms.png" width="120" height="120" alt="logo OpenClassrooms">
</div>


## What I used for this project :


### Main language :

<img src="https://img.shields.io/badge/php-8.3.1-%23777BB4?logo=php" alt="php banner"> <img src="https://img.shields.io/badge/symfony-6.4-%25%23000000%3F?logo=symfony" alt="Static Badge">



For this project I used the framework Symfony.
I have made all the project in MVC advanced pattern.


### Front-end :

<img src="https://img.shields.io/badge/HTML-5-%23E34F26?logo=html5" alt="HTML5 banner"> <img src="https://img.shields.io/badge/CSS-3-%231572B6?logo=css3" alt="CSS3 banner"> <img src="https://img.shields.io/badge/Bootstrap-5.3.2-%237952B3?logo=bootstrap" alt="bootstrap banner"> <img src="https://img.shields.io/badge/Twig-3.0-%23bacf29" alt="Twig banner">

I used HTML5 and CSS3 Bootsrap (a free theme from <a href="https://bootswatch.com/">Bootswatch</a> : Cyborg) and Twig.


### Database :

<img src="https://img.shields.io/badge/MySQL-8.0.30-%234479A1?logo=mysql" alt="MySQL banner"> <img src="https://img.shields.io/badge/HeidiSQL-12.1.0-%234479A1?logo=mysql" alt="MySQL banner"> <img src="https://img.shields.io/badge/Laragon-6.0-%230E83CD?logo=laragon" alt="MySQL banner">

For the database I use MySQL with HeidiSQL because they are in my development server solution <a href="https://laragon.org/index.html">Laragon</a>


### Tools :

<img src="https://img.shields.io/badge/Composer-2.6.5-%23885630?logo=composer" alt="composer banner"> <img src="https://img.shields.io/badge/Tools-GitHub-%23181717?logo=github" alt="GitHub banner"> <img src="https://img.shields.io/badge/fakerPHP-1.23.1-%23000000"  alt="fakerPHP banner"> <img src="https://img.shields.io/badge/MailHog-1.0.1-%23B10000" alt="MailHog banner"> <img src="https://img.shields.io/badge/fork-1.92.0.0-%2300AFF0" alt="Fork banner"> 

I used <a href="https://getcomposer.org/">Composer</a> to install all the libraries and tools I needed.

To test the function to send mail I used <a href="https://github.com/mailhog/MailHog">MailHog</a>.
To generate the fixtures I used <a href="https://fakerphp.github.io/">Fakerphp</a>

This project is avaliable on <a href="https://github.com/">GitHub</a>, and received a **Platinum medal** in <a href="https://insight.symfony.com/">SymfonyInsight</a> ! You can see <a href="https://insight.symfony.com/projects/229e245e-bc90-4871-97cb-374f6bca10ee">the last analyse here.</a>

<div align="center">
    <img src="https://insight.symfony.com/projects/229e245e-bc90-4871-97cb-374f6bca10ee/big.svg" alt="code quality from SymfonyInsight">
    <br>
    <br>
    <br>
</div>

It also received a **A** notation in <a href="https://www.codacy.com/">Codacy</a> ! You can see the last analysis here : <a href="https://app.codacy.com/gh/Marine-Sanson/snowtricks/dashboard">https://app.codacy.com/gh/Marine-Sanson/snowtricks/dashboard</a>

<div align="center">
    <img src="https://img.shields.io/codacy/grade/591cf51d80244641be9c2514f607a6ce" alt="code quality from Codacy">
    <br>
    <br>
    <br>
</div>

## How to run this project :

To run this project, you need to use composer, and run :

```
composer install
```

For your connection informations (database and SMTP), copy the ```.env``` file in a ```.env.local``` file and replace the data by yours

To create the database run :

```
php bin/console doctrine:database:create
```

Then to create the tables run :
```
php bin/console doctrine:migrations:migrate
```
answer : y

To load the fake fixtures run :

```
php bin/console doctrine:fixtures:load
```
answer : y

To run the project in your navigator first run the symfony server :
```
symfony server:start -d
```

Start Mailhog to catch the emails. Go to <a href="http://localhost:8025">http://localhost:8025</a> to read them.


### Warning ###
To connect you, pick an email in the database and use it. The password is "mdpass" for all fake users.
<br>
Be careful when you try this application with fake fixtures, I cheat with the pictures, I use the same several times. If you delete one it may disappear for several tricks. Of course it won't happen with real datas.

## GitHub stats : ##

[![Top Langs](https://github-readme-stats.vercel.app/api/top-langs/?username=Marine-Sanson&layout=compact)](https://github.com/Marine-Sanson/snowtricks/tree/develop)
