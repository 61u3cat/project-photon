# Project Photon

A Laravel-based Task Management API and Web Frontend.

---

## 🚀 Features

- User registration and login (JWT Auth)
- Role-based access (admin/user)
- Task CRUD (Create, Read, Update, Delete)
- Mark tasks as complete (user)
- Admin can assign and delete tasks
- Web frontend with Bootstrap 5
- API endpoints for integration

---

## 🛠️ Local Setup

### 1. Clone the repository

```sh
git clone https://github.com/your-username/project-photon.git
cd project-photon
```

### 2. Install dependencies

```sh
composer install
npm install
```

### 3. Environment setup

Copy `.env.example` to `.env` and update as needed:

```sh
cp .env.example .env
```

Generate an app key:

```sh
php artisan key:generate
```

Set your database credentials in `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project_photon
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run migrations

```sh
php artisan migrate
```

### 5. Build frontend assets

```sh
npm run build
```

### 6. Start the server

```sh
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000)

---

## 🌐 Deployment (Vercel)

- Use the provided `vercel.json` for PHP routing.
- Set environment variables (including `APP_KEY`, `DB_*`, `JWT_SECRET`) in the Vercel dashboard.
- **Do not set an Output Directory** in Vercel settings.
- Set Framework Preset to **Other**.

---

## 📚 API Endpoints

### Register

```http
POST /api/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "secret123"
}
```

### Login

```http
POST /api/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "secret123"
}
```
**Response:**
```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOi..."
}
```

### Get Tasks (Authenticated)

```http
GET /api/tasks
Authorization: Bearer {token}
```

### Create Task (Admin only)

```http
POST /api/tasks
Authorization: Bearer {admin_token}
Content-Type: application/json

{
  "title": "New Task",
  "description": "Task details",
  "due_date": "2024-07-01",
  "user_id": 2
}
```

### Mark Task Complete (User only)

```http
PATCH /api/tasks/{id}/complete
Authorization: Bearer {user_token}
```

### Delete Task (Admin only)

```http
DELETE /api/tasks/{id}
Authorization: Bearer {admin_token}
```

---

## 🖥️ Web Frontend

- `/register` — User registration form
- `/login` — User login form
- `/tasks-view` — Task dashboard (after login)

---

## ⚙️ Environment Variables (Sample)

Set these in your `.env` and in Vercel dashboard:

```
APP_KEY=base64:your-generated-key
APP_URL=https://your-vercel-domain.vercel.app
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password
JWT_SECRET=your-jwt-secret
```

---
## 🙏 Acknowledgements

This project was developed with the help of the following resources:

- [ChatGPT](https://chat.openai.com/) for code suggestions and troubleshooting
- [Claude](https://claude.ai/) for programming guidance
- [Stack Overflow](https://stackoverflow.com/) for community Q&A and solutions
- [YouTube](https://www.youtube.com/) for video tutorials and walkthroughs

Special thanks to the open-source community for documentation, packages, and inspiration.
## 📝 License

**Happy coding!**
