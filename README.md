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

# Domain Events

Below are descriptions of the domain events in our systems and the data fields contained within.

## Order Was Placed

When a customer finds the products that they'd like to purchase and checks out, the order becomes placed. The customer will then wait to get an order confirmation before they can pay. This isn't the model that Amazon.com etc uses. But, it's common in B2B sales. 

* Order ID - Order ID is an identifier for this specific order. No other order will have this ID.
* Customer ID - Customer ID is an identifier for this specific customer. No other customer will have this ID. 
* Products - Products is a list of Product IDs that the customer wants to purchase.
* Total Price - Total Price is the amount of money that must be paid before the order is completed. 
* Currency - Currency is an identifier for the currency type the order was placed with. 
* Placed At - Placed At is the time and date of when the customer placed the order.

## Order Was Confirmed

After an order is placed an employee will check inventory and ensure that the order conforms to their policies. Then, the employee will confirm the order. Order confirmation is required before the order can be shipped or even before the customer can make payments.

* Order ID - The unique order identifier.
* Confirmed By - Confirmed By is an identifier for the specific employee that confirmed the order. No other employee will have this ID.
* Confirmed At - Confirmed At is the time and date of when the employee confirmed the order.

## Payment Was Received

Once the order is confirmed, the customer is free to make payments. It's possible for the customer to make multiple payments with amounts smaller than the total price. However, the order will not be marked as complete until the total amount has been received.

* Order ID - The unique order identifier.
* Amount - The amount of money that was received. This should be stored in a string format to prevent mathematic operations.
* Currency - An identifier for the currency type that was received. 
* Received At - Received At is the time and date that the payment was received.

## Order Was Completed

Once the received amount is the same as the total amount of the order then the order is automatically marked complete. This progresses the order to the fulfillment department where they'll ship the ordered products to the customer.

* Order ID - The unique order identifier.
* Completed At - Completed At is the time and date that the order was completed.

## Order Was Fulfilled

Once the order has been completed and our employee has packed and shipped the order, the order is marked as fulfilled by our employee. This significes the end of the order process.

* Order ID - The unique order identifier.
* Tracking Number - Tracking Number is a unique identifier that allows the customer to track the progress of the order's delivery. 
* Fulfilled By - Fulfilled By is the ID of the employee who fulfilled the order.
* Fulfilled At - Fulfilled At is the time and date that the order was fulfilled.

**More documentation to come.**

# Routing

## Middleware

fake-customer-session  
fake-employee-session