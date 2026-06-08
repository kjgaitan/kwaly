# Kwaly

Kwaly es una aplicacion web de gestion financiera personal desarrollada con Laravel. Permite organizar transacciones, presupuestos, facturas, metas financieras, reportes, educacion financiera, calendario y gastos compartidos.

## Requisitos

- PHP 8.2 o superior
- Composer
- Node.js y npm
- MySQL/MariaDB, por ejemplo desde XAMPP

## Configuracion

1. Crea una base de datos MySQL llamada `kwaly` desde phpMyAdmin.
2. Revisa el archivo `.env` y confirma estos valores:

```env
APP_NAME=Kwaly
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kwaly
DB_USERNAME=root
DB_PASSWORD=
```

3. Instala dependencias y prepara la base de datos:

```bash
composer install
npm install
php artisan migrate --seed
npm run build
```

4. Arranca la aplicacion:

```bash
php artisan serve
```

La aplicacion quedara disponible en `http://127.0.0.1:8000`.

## Tests

```bash
php artisan test
```
