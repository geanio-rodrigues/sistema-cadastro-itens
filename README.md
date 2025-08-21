# Sistema de Cadastro de Itens por Departamento

Stack: Docker (PHP-FPM + Nginx + MariaDB), Laravel 11, Vue 3 + Vite + Axios.

## Como subir
docker-compose up -d --build

---

## Estratégia de Branches

Este projeto utiliza um fluxo de trabalho com as seguintes branches principais:

-   **`main`**: Contém o código de produção estável e testado. As mesclagens para esta branch são feitas a partir da `develop`.
-   **`develop`**: É a branch principal de desenvolvimento. Contém o código com as novas funcionalidades já integradas. É a base para a criação de novas features.
-   **`feature/<nome-da-feature>`**: Criadas a partir da `develop` para desenvolver novas funcionaliddes. Ao concluir, são mesclados de volta na `develop` via Pull Request.