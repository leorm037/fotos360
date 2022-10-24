# fotos360
Visualizador de fotos panorâmicas 360º 2:1.

# Docker commands

## Build
```
docker build -t leorm037/ubuntu-last-php:2.0.0 .
```
or
```
docker build -t --no-cache leorm037/ubuntu-last-php:2.0.0 .
```
## Run

docker run -itv c:\desenvolvimento\git\fotos360:/var/www/html/fotos360 -p 80:80 --rm leorm037/ubuntu-last-php:2.0.0 bash

## Apache2 Httpd

apache2ctl start

## Browser

http://localhost