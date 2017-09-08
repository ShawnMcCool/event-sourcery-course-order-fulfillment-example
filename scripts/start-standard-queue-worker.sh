#!/bin/bash

echo "Running standard queue worker..."
/usr/bin/php artisan queue:work --queue=default --tries=1
