# Ecommerce B2C API — Prueba Técnica (Laravel 10, PHP 8.1)

Este README recoge *todo lo solicitado* en la prueba: cómo **levantar el proyecto**, **instalar dependencias**, **configurar la base de datos**, **ejecutar migraciones y seeders** y **probar los endpoints** (curl/Postman). Además incluye un *resumen Git* con ramas y commits.

---

## 1 Levantar el proyecto

Puedes usar **Apache (Laragon)** o **Artisan**.

### Opción A — Apache (Laragon, puerto 80)
- Apunta el **DocumentRoot** del VirtualHost a la carpeta `public/` del proyecto.
- URL de la app: **http://localhost**
- Si usas Laragon con dominio amigable (`*.test`), apunta a `public/` igual. La base URL cambiará (p. ej., `http://trevenque.test`).

### Opción B — Artisan (alternativa local)
```bash
php artisan serve  # http://127.0.0.1:80
```

---

## 2 Instalar dependencias

```bash
composer install
```

**(Opcional) Solo desarrollo:** barra de depuración
```bash
composer require --dev barryvdh/laravel-debugbar
```
> Asegúrate de tener `APP_ENV=local` y `APP_DEBUG=true` en `.env` para verla en local.

---

## 3 Configurar la base de datos

```bash
cp .env.example .env
php artisan key:generate
```
Edita en `.env` los datos de conexión:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=trevenque
DB_USERNAME=trevenque
DB_PASSWORD=trevenque
```

> **Notas Laravel 10** (PHP 8.1+):
> - En todos los **FormRequest** incluye: `public function authorize(): bool { return true; }`.
> - Para actualizar nombre único de categoría usa: `Rule::unique('categories','name')->ignore($id)`.
> - En `DELETE`, devuelve **204** con: `return response()->noContent();`.

---

## 4 Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

---

## 5 Probar los endpoints

**Base URL (Apache/Laragon):** `http://localhost`  
**Base URL (Artisan):** `http://127.0.0.1:80`

Todos los endpoints están bajo `/api`:

- `GET    /api/categories`
- `POST   /api/categories`
- `PUT    /api/categories/{id}`
- `DELETE /api/categories/{id}`
- `GET    /api/products?per_page=10&category_id=&active=`
- `POST   /api/products`
- `PUT    /api/products/{id}`
- `DELETE /api/products/{id}`
- `POST   /api/products/{id}/images`
- `DELETE /api/products/{id}/images/{image_id}`

### 5.1 Ejemplos con curl (Windows CMD / PowerShell)
> Cambia la base URL según tu opción (Apache/Artisan). Aquí usamos **Apache** (`http://localhost`).

```bash
REM Listar categorías
curl http://localhost/api/categories

REM Crear categoría
curl -X POST http://localhost/api/categories ^
 -H "Content-Type: application/json" ^
 -d "{"name":"Lácteos"}"

REM Listar productos (10 por página, solo activos)
curl "http://localhost/api/products?per_page=10&active=true"

REM Filtrar por categoría (id=1)
curl "http://localhost/api/products?category_id=1"

REM Crear producto
curl -X POST http://localhost/api/products ^
 -H "Content-Type: application/json" ^
 -d "{"name":"Leche Entera","price":0.95,"stock":50,"active":true,"category_id":1}"

REM Cambiar estado (activo/inactivo)
curl -X PUT http://localhost/api/products/1 ^
 -H "Content-Type: application/json" ^
 -d "{"active":false}"

REM Añadir imagen a un producto
curl -X POST http://localhost/api/products/1/images ^
 -H "Content-Type: application/json" ^
 -d "{"url":"https://cdn.example.com/p1.jpg"}"

REM Borrar imagen (image_id=3)
curl -X DELETE http://localhost/api/products/1/images/3
```

### 5.2 Postman
Crea una **Collection** con estas rutas y cuerpo **raw JSON (application/json)** donde aplique:
- `GET  http://localhost/api/categories`
- `POST http://localhost/api/categories`
- `GET  http://localhost/api/products?per_page=10&active=true`
- `GET  http://localhost/api/products?category_id=:id`
- `POST http://localhost/api/products`
- `PUT  http://localhost/api/products/:id`
- `POST http://localhost/api/products/:id/images`
- `DELETE http://localhost/api/products/:id/images/:image_id`

---

## 6 Git — ramas y commits (resumen entregable)

Ramas sugeridas:
- `feature/categories-api`
- `feature/products-api`
- `feature/product-images`
- `feature/frontend`
- `chore/deploy-script`

Mensajes de commit (convención sugerida y alguno más):
- `feat(categories): CRUD + validations + unique index`
- `feat(products): filters (category_id,active) + pagination + resource`
- `feat(product-images): endpoints POST/DELETE + request + routes`
- `feat(frontend): listing + filters + toggle + create form`
- `chore(deploy): add scripts/deploy.sh`

Flujo típico por rama:
```bash
git checkout -b feature/categories-api
# ... cambios ...
git add -A
git commit -m "feat(categories): CRUD + validations + unique index"
git push -u origin feature/categories-api
# Crear PR, revisar y mergear a main
```

---

## 7 Créditos/Notas

- Stack usado: **Laravel 10 (PHP 8.1)** + MySQL/MariaDB.
- Frontend minimal en `public/frontend` para listado/creación.
- Código organizado por capas (Controllers, Requests, Resources, Models) y con *eager loading* para evitar N+1.
