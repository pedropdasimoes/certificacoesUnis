## Como iniciar

1. `npm install`
2. `composer install`
3. Altere o arquivo .env.example para .env
4. Configure o arquivo .env e não esqueça de configurar a API do Google
5. Configure o banco de dados no seu .env e crie um banco limpo
6. `php artisan migrate:fresh --seed`
7. `php artisan key:generate`
8. `php artisan storage:link`
9. `php artisan serve`
10. `npm run watch`
11. Acesse: http://localhost:8000 ou sua APP_URL (no .ENV)

## Conta Administrativa

-   **Email:** admin@certificados.com.br
-   **Senha:** admin

## Conta para Desenvolvimento

-   **Email:** developer@certificados.com.br
-   **Senha:** developer
