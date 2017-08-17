#!/bin/bash

/usr/bin/php artisan queue:work --queue=event_dispatch --tries=3
