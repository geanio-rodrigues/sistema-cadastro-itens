# Sistema de Cadastro de Itens por Departamento

## Tecnologias Utilizadas

Este projeto foi construído utilizando um conjunto de tecnolgoias modernas para desenvolvimento web full-stack, encapsuladas em uma ambiente Docker para garantir consistência e portabilidade.

### **Back-end**
* **PHP:** `8.2`
* **Laravel:** `12.25`
* **MariaDB:** `10.6`

### **Front-end**
* **Vue.js:** `3.5`
* **Vite:** `7.1`
* **Axios:** Utilizado para as requisições HTTP para a API.

### **Ambiente de Desenvolvimento**
* **Docker & Docker Compose:** Orquestração dos contêineres de serviço.
* **Nginx:** Servidor web e proxy reverso.

---

## Endpoints da API

A API segue o padrão RESTful do Laravel com `apiResource`.

**Departamentos:**

-    **GET /api/departments** → lista todos os departamentos
-    **GET /api/departments/{id}** → obtém um departamento específico
-    **POST /api/departments** → cria um novo departamento
-    **PUT /api/departments/{id}** → atualiza um departamento
-    **DELETE /api/departments/{id}** → remove um departamento
  
**Itens:**

-    **GET /api/items** → lista todos os itens
-    **GET /api/items/{id}** → obtém um item específico
-    **POST /api/items** → cria um novo item
-    **PUT /api/items/{id}** → atualiza um item
-    **DELETE /api/items/{id}** → remove um item

---

## Instalação e execução

**Pré-requisitos:**
-  [Docker](https://docs.docker.com/get-started/get-docker/)
-  [Docker Compose](https://docs.docker.com/compose/install/)


1. **Clone o repositório**
```bash
git clone https://github.com/geanio-rodrigues/sistema-cadastro-itens
cd sistema-cadastro-itens
```

2. **Suba os containers com Docker Compose**
```bash
docker compose up -d --build
```

3. **Acesse o container do backend Laravel para rodar as migrations**
```bash
docker exec -it app_laravel php artisan migrate --seed
```

4. **Acesse a Aplicação**
  -  **Frontend (Vue 3):** [http://localhost:5173](./)
  -  **Backend (Laravel API):** [http://localhost:8000](./)

---

## Credenciais do Banco de Dados

As credencias do banco de dados para o ambiente local são definindas no arquivo `docker-compose.yml` e passadas como variáveis de ambiente para o container da aplicação.

-   **Host:** `db`
-   **Porta:** `3306`
-   **Banco de Dados:** `laravel_db`
-   **Usuário:** `user`
-   **Senha:** `password`

Esses valores devem ser replicados no arquivo `.env` do Laravel para que a aplicação consiga se conectar ao banco de dados.

---

## Estrutura dos Containers

-   **app_laravel** → Container da aplicação Laravel
-   **nginx_server** → Servidor Nginx servindo a aplicação
-   **mariadb_database** → Banco de dados MariaDB

---

## Estratégia de Branches

Este projeto utiliza um fluxo de trabalho com as seguintes branches principais:

-   **`main`**: Contém o código de produção estável e testado. As mesclagens para esta branch são feitas a partir da `develop`.
-   **`develop`**: É a branch principal de desenvolvimento. Contém o código com as novas funcionalidades já integradas. É a base para a criação de novas features.
-   **`feature/<nome-da-feature>`**: Criadas a partir da `develop` para desenvolver novas funcionaliddes. Ao concluir, são mesclados de volta na `develop` via Pull Request.

---

## Padrão de Commits (Conventional Commits)

Para manter o histórico do projeto claro e rastreável, seguimos o padrão de *Conventional Commits*. A estrutura da mensagem de commit deve ser:

` <tipo>(<escopo>): <descrição> `

**Tipos mais comuns:**
-   **`feat`**: Uma nova funcionalidade.
-   **`fix`**: Uma correção de bug.
-   **`docs`**: Alterações na documentação.
-   **`style`**: Alterações de formatação (ponto e vírgula, espaços, etc.).
-   **`refactor`**: Refatoração de código que não altera a funcionalidade externa.
-   **`test`**: Adição ou correção de testes.
-   **`chore`**: Atualizações de tarefas de build, pacotes, etc.

**Exemplo:** `chore(docker): adiciona o docker-compose com os serviços app/nginx/db`