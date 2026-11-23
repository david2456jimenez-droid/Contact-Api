# Contact API

API REST en Laravel para gestionar contactos personales. Cada usuario inicia sesión con un token y solo puede ver y modificar sus propios contactos.

## Requisitos

- PHP 8.3 o superior
- Composer
- MySQL

## Instalación

1. Instalar dependencias:

   ```bash
   composer install
   ```

2. Crear el archivo de entorno y la clave de la aplicación:

   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

3. Crear **dos bases de datos vacías** en MySQL (cotejamiento `utf8mb4_unicode_ci`):

   - `db_contact_api`: base de desarrollo.
   - `db_contact_api_test`: base que usan los tests.

4. Revisar en `.env` los datos de conexión (`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

5. Crear las tablas y los datos de ejemplo:

   ```bash
   php artisan migrate:fresh --seed
   ```

6. Iniciar el servidor:

   ```bash
   php artisan serve
   ```

La documentación interactiva queda en `http://127.0.0.1:8000/docs/api`.

## Usuarios de ejemplo

El seeder crea tres usuarios. La contraseña de todos es `password`.

| Correo | Contactos |
|---|---|
| admin@contact.test | 0 |
| uno@gmail.com | 5 |
| dos@gmail.com | 3 |

## Endpoints

Todas las rutas empiezan con `/api/v1`. Las marcadas con token requieren el encabezado `Authorization: Bearer <token>`.

| Método | Ruta | Acceso | Descripción |
|---|---|---|---|
| GET | `/health` | Público | Estado del servicio |
| POST | `/auth/login` | Público (5 intentos por minuto) | Devuelve un token |
| GET | `/auth/me` | Token | Perfil del usuario |
| POST | `/auth/logout` | Token | Revoca el token usado |
| GET | `/contacts` | Token | Lista los contactos del usuario |
| POST | `/contacts` | Token | Crea un contacto |
| GET | `/contacts/{id}` | Token | Perfil de un contacto |
| PUT | `/contacts/{id}` | Token | Actualiza un contacto |
| DELETE | `/contacts/{id}` | Token | Elimina un contacto (soft delete) |

## Reglas de negocio

- Sin token, la API responde `401` en JSON.
- Un contacto de otro usuario responde `403`.
- Una ruta o un contacto que no existe responde `404` en JSON.
- El correo y el teléfono de un contacto no se pueden repetir (`422`).
- Eliminar un contacto es un borrado suave: se guarda la fecha en `deleted_at` y el contacto deja de aparecer en las consultas.
- Si un contacto no tiene `avatar_url`, la API entrega un avatar por defecto con la primera letra del nombre y un color.

## Tests

Los tests usan la base `db_contact_api_test`, que debe existir antes de ejecutarlos.

```bash
php artisan test
```