#!/bin/bash

echo "Running event dispatch queue worker..."
/usr/bin/php artisan queue:work --queue=event_dispatch --tries=1
