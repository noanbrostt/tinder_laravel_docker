# Laravel Postgres
## PORTAS
- app: 8098
- db: 7098

### Descrição:
Projeto base para utilização do laravel com o banco em postgres através do docker

### Powered By
Israel Glixinski - Inicio em 2025-01-16

### Passos:

1 - git clone https://github.com/israelglixinski/docker_example_laravelpostgres.git
(ou git clone https://gitlab.com/israel_glixinski/docker_example_laravelpostgres.git) 
2 - cd laravel_postgres
3 - docker-compose up --build -d

### Histórico:
2025-01-16 - Israel Glixinski
* Funcional Laravel
* Funcional Postgres
* Trasição de arquivos funcional

## Operação de Containers
### DESENVOLVIMENTO
#### DEV - UP
Inicia os containers de desenvolvimento.
- make dev-up
    - docker compose -f docker-compose.dev.yml --env-file .env.dev up -d --build

#### DEV - UP - INTERACT
Inicia os containers de desenvolvimento em modo interação.
- make dev-up-interact
    - docker compose -f docker-compose.dev.yml --env-file .env.dev up --build

#### DEV - DOWN
Para os containers de desenvolvimento.
Comandos MAKE facilitam a operação.
- make dev-down
    - docker compose -f docker-compose.dev.yml down

#### DEV - CLEAR
Para os containers de desenvolvimento e remove os volumes.
- make dev-clear
    - docker compose -f docker-compose.dev.yml down -v

#### DEV - COMANDOS
Executa comandos dentro dos containers.
- docker exec -it tinder-CONTAINER-dev COMANDO

#### DEV - LOGS 
Verifica os logs.
- Logs do Container
    - docker logs tinder-CONTAINER-dev (funciona em qualquer container do POD)
        - Ex: docker logs tinder-app-dev
        - Ex: docker logs -f --tail 10 tinder-app-dev (ultimas 10 linhas)
- Logs do laravel
    - make dev-app-logs
    -   docker exec -it tinder-app-dev storage/logs/laravel.log

### PRODUÇÃO
#### PROD - UP
Inicia os containers de produção
- docker compose -f docker-compose.prod.dev.yml --env-file .env.prod up -d --build

#### PROD - DOWN
Para os containers de produção
- docker compose -f docker-compose.prod.yml down

#### PROD - MIGRATE - DATABASE
Executa migrations e seeders dentro da produção. (USAR COM CAUTELA) 
- make prod-migrate-database

#### PROD - LOGS 
Verifica os logs.
- Logs do Container
    - docker logs tinder-CONTAINER-prod (funciona em qualquer container do POD)
        - Ex: docker logs tinder-app-prod
        - Ex: docker logs -f --tail 10 tinder-app-prod (ultimas 10 linhas)
- Logs do laravel
    - make prod-app-logs
    -   docker exec -it tinder-app-prod storage/logs/laravel.log
