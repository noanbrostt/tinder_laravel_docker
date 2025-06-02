# Laravel Postgres

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
- docker compose -f docker-compose.dev.yml --env-file .env.dev up -d --build

#### DEV - DOWN
- docker compose -f docker-compose.dev.yml down

#### DEV - COMANDOS
- docker exec -it tinder-app-dev COMANDO

#### DEV - LOGS 
- Logs do Container
    - docker logs tinder-CONTAINER-dev (funciona em qualquer container do POD)
        - Ex: docker logs tinder-app-dev
        - Ex: docker logs -f --tail 10 tinder-app-dev (ultimas 10 linhas)
- Logs do laravel
    - docker exec -it tinder-app-dev storage/logs/laravel.log

### PRODUÇÃO
### PROD - UP
- docker compose -f docker-compose.prod.dev.yml --env-file .env.prod up -d --build

### PROD - DOWN
- docker compose -f docker-compose.prod.yml down