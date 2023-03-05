# Mocks em PHP: entenda os dublês de testes ALURA
## Comando para subir o container
```terminal
docker-compose up -d
```
## Comando para acessar o container
```terminal
docker exec -it phpmocks /bin/bash
```
## Ao acessar o container a primeira vez deve rodar o comando para baixar todas as dependências do phpUnit conforme comando abaixo
```terminal
composer install
```
## Ao acessar o container para rodar os test basta executar o comando abaixo
```terminal
composer run-test
```