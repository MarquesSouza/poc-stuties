# Xdedug Dias de Dev
## Docker file deve ser copiado para dentro da pasta php ini a configuração do xdebug
```docker
COPY 90-xdebug.ini "${PHP_INI_DIR}/conf.d"
```
## Depois instalado e habilitado xdebug na imagem 
```docker
RUN pecl install xdebug 
RUN docker-php-ext-enable xdebug
```
## No docker manifest deve ser informado a configuração abaixo para que a rede interna do container seja enchergada fora da maquina
```docker
extra_hosts:
    - "host.docker.internal:host-gateway"
```
## Comando docker start container
```docker
docker-compose up -d
```
## Configurações xdebug para ativar modo debug, desabilitar buscar por todos os host por ip e habilitar host client docker rede interna
```
xdebug.mode=debug
xdebug.discover_client_host=0
xdebug.client_host=host.docker.internal
xdebug.cli_color= 2
```
### Obs:Instalar plugin navegador xdebug helper para ele adicionar tag no final da request de debug para ativar o debug
## Configuração vscode para escutar xdebug
```
"name": "Listen for Xdebug",
    "type": "php",
    "request": "launch",
    "port": 9003,
    "pathMappings": {
        "/app":"${workspaceFolder}"
    }
```
### Obs: xdebug versao 2 ou inferiores usa a porta 9000 as versões 3 e superiores usa a porta 9003
## Modo debug com configuração de exibir as exeption trace, oque foi solicitado na request e qual servidor e as  variaveis locias carregas.
```
xdebug.mode=develop
xdebug.cli_color=2
xdebug.show_exception_trace=1
xdebug.dump.SERVER = REMOTE_ADDR, REQUEST_METHOD
xdebug.dump.GET = *
xdebug.show_local_vars=1
```
# Modo  profile de indentificar performace no codigo
## no profile e necessario configura a pasta de saida da coleta de dados do profile. Caso queria somente analizar oque foi solicitado pela request acione o modo trigger
```
xdebug.mode=profile
xdebug.cli_color=2
xdebug.show_exception_trace=1
xdebug.dump.SERVER = REMOTE_ADDR, REQUEST_METHOD
xdebug.dump.GET = *
xdebug.show_local_vars=1
xdebug.output_dir=/app
xdebug.start_with_request=trigger
```
### kcachegrind , ferramenta para analize de cache do profile

```terminal
sudo apt install kcachegrind 
```
### webgrind , blackfire.io
```
https://github.com/jokkedk/webgrind
```
# Modo debug
## Tem que fazer configruação de client host para que o container do docker e a ide se encontrem
```
xdebug.mode=debug
xdebug.cli_color=2
xdebug.show_exception_trace=1
xdebug.dump.SERVER = REMOTE_ADDR, REQUEST_METHOD
xdebug.dump.GET = *
xdebug.show_local_vars=1
xdebug.output_dir=/app
xdebug.start_with_request=trigger
xdebug.client_host=host.docker.internal
```
## obs Breack point tem como configura uma condição para ele ativar
