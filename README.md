# Sistema de Cadastro de Itens por Departamento

Stack: Docker (PHP-FPM + Nginx + MariaDB), Laravel 11, Vue 3 + Vite + Axios.

## Como subir
docker-compose up -d --build

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