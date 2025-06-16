# 🔥 Clone do Tinder Corporativo

Este é um projeto desenvolvido internamente para uso corporativo, replicando a lógica e interação do Tinder em um ambiente empresarial. O sistema permite login, cadastro, gerenciamento de usuários e interação entre perfis de forma gamificada.

## 🚀 Funcionalidades

- Tela de **login**
- Tela de **cadastro de usuários**
- Tela de **validação e aceitação de novos cadastros**
- Tela de **matchs estilo Tinder** (curtir/ignorar)
- Tela de **interações** (usuários que curtiram ou deram match)

## 🛠️ Tecnologias utilizadas

- **Laravel** (backend)
- **HTML, CSS, JavaScript puro** (frontend)
- **Docker** (ambiente de desenvolvimento e produção)

## 📦 Como rodar o projeto

> ⚠️ É necessário ter o Docker e o Docker Compose instalados em sua máquina.

```bash
# Clone este repositório
git clone https://github.com/seu-usuario/nome-do-repositorio.git
cd nome-do-repositorio

# Suba os containers
docker-compose up -d

# Acesse o container da aplicação
docker exec -it nome-do-container-app bash

# Instale as dependências do Laravel
composer install

# Configure o .env
cp .env.example .env
php artisan key:generate

# Rode as migrations (se necessário)
php artisan migrate

# Acesse no navegador
http://localhost:8000
```
## 👨‍💻 Time de desenvolvimento

- **Noan Caliel Brostt** — Responsável por todo o frontend e parte da lógica backend
- **Matheus Andrei Arantes** — Desenvolvedor principal do backend (Laravel)
- **Mauricio Ferrari** — Responsável por toda a configuração de servidores e ambiente Docker


## 📄 Licença

Uso interno. Disponibilizado neste repositório pessoal apenas para fins de portfólio e demonstração técnica.
