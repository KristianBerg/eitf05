#!/bin/bash
cd "$(dirname "$0")"

open http://127.0.0.1:8080/
php -S 127.0.0.1:8080
