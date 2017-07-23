This is the readme for the order fulfillment example application. Installation instructions and much more will be added in this file.


# Installation

First, add your ssh key to your Gitlab profile. Then, clone the repository. Don't forget to clone recursively.

```
git clone --recursive git@git.eventsourcery.com:event-sourcery/order-fulfillment-example.git
```

Then, make sure that you have modern versions of Virtualbox, Ansible, and Vagrant set up. Don't worry. If you're running Windows or don't want to use the virtual machine then it's not a problem. Just, set up a regular PHP development environment including a MySQL database.

Then, install the composer dependencies.

```
vagrant ssh
composer install
```

Set up the framework.

```
vagrant ssh
cp laravel/.env.example laravel/.env
php artisan key:generate
```

Then, you can access the page in your browser at [http://localhost:8080](http://localhost:8080)


**More documentation to come.**

# Routing

## Middleware

fake-customer-session  
fake-employee-session