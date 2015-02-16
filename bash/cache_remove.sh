#!/bin/env bash
sudo rm -rf app/cache/
php app/console cache:clear --no-warmup
sudo chmod -R 777 app/{cache,logs}
sudo chmod -R 777 web/
