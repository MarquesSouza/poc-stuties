# Xdedug Alura

```docker
docker run --rm -itv $(pwd):/app -w /app -v $(pwd)/99-xdebug.ini:/usr/local/etc/php/conf.d/99-xdebug.ini -p 8123:8123 php-xdebug bash

```
