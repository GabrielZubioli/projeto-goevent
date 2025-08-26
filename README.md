# Goevent - Sistema de Eventos

Este é um sistema de gerenciamento de eventos desenvolvido em **Laravel**, com autenticação de usuários, páginas públicas e restritas, além de uma interface organizada.

---

## 🚀 Funcionalidades
- Registro de usuários
- Login e recuperação de senha
- Perfil do usuário
- Página inicial com eventos

---

## 🛠️ Tecnologias utilizadas
- [Laravel 10](https://laravel.com/)
- [PHP 8.1+](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [MySQL](https://dev.mysql.com/) (porta **3308**)
- Blade
- Boxicons

---

## ⚙️ Como rodar o projeto

### ✅ Requisitos
- PHP >= 8.1
- Composer
- MySQL (porta configurável, padrão **3308** no XAMPP)
- Node.js & NPM (opcional para compilação de assets)

  
### 🔧 Configuração do XAMPP (Porta MySQL 3308)
1. Abra o **XAMPP Control Panel**  
2. Clique em **Config > my.ini** no MySQL  
3. Localize as linhas:
```ini
port=3306
```
4. E altere para::
```ini
port=3308
```
---

### 1. Clonar o repositório
```bash
git clone https://github.com/GabrielZubioli/projeto-goevent.git
cd goevent
```

### 2.Instalar dependências
```bash
composer install
npm install && npm run dev
```

### 3.Configurar o .env
```bash
APP_NAME=Goevent
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3308
DB_DATABASE=goevent
DB_USERNAME=root
DB_PASSWORD=
```
### Depois gere a chave do Laravel
```bash
php artisan key:generate
```
### 4.Rodar as migrations
```bash
php artisan migrate
```
### 5.Iniciar o servidor
```bash
php artisan serve
```
### O projeto estará rodando em:
```bash
http://127.0.0.1:8000
```

## 📌 Rotas do Projeto

As rotas principais estão no arquivo `routes/web.php`:

- `/login` → Tela de login (`auth.login`)
- `/register` → Tela de registro (`auth.register`)
- `/forgot-password` → Recuperação de senha
- `/events` → Página inicial para criação e listagem de eventos (`event.blade.php`)
- `/profile` → Perfil do usuário logado (`profile.blade.php`)
