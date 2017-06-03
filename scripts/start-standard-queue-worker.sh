#!/bin/bash

/usr/bin/php artisan queue:work --queue=default --tries=3
