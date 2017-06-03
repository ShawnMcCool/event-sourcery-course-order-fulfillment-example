#!/bin/bash

tail -f laravel/storage/logs/laravel.log | grep local.ERROR
