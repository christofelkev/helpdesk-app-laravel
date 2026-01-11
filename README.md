# Helpdesk App

A modern, full-featured helpdesk ticketing system built with Laravel 10. Manage support tickets, track issues, and streamline communication between clients and support staff.

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

---

## Features

### Ticket Management
- Create, view, edit, and delete support tickets
- Assign tickets to staff members
- Track ticket status (open, in progress, resolved, closed)
- Set priority levels and categories
- Add comments and attachments to tickets
- Tag tickets for easy organization

### Role-Based Access Control
| Role | Capabilities |
|------|-------------|
| **Admin** | Full system access, user management, view all tickets |
| **Staff** | Manage assigned tickets, respond to clients |
| **Client** | Create tickets, track own requests, add comments |

### Dashboard
- Role-specific dashboards for Admin, Staff, and Client
- Quick overview of ticket statistics
- Recent activity tracking

### Additional Features
- SLA (Service Level Agreement) tracking
- Ticket activity logging
- Notification system
- User authentication (login/register)

---

## Tech Stack

- **Backend:** Laravel 10, PHP 8.1+
- **Frontend:** Blade Templates, TailwindCSS, Vite
- **Database:** MySQL / SQLite / PostgreSQL
- **Authentication:** Laravel Sanctum

---

## Getting Started

### Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js & npm
- MySQL or any supported database

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/helpdesk-app-laravel.git
   cd helpdesk-app-laravel
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Set up environment file**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your database** in `.env`
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=helpdesk
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Build frontend assets**
   ```bash
   npm run build
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` in your browser.

---

## Project Structure

```
helpdesk-app-laravel/
├── app/
│   ├── Http/Controllers/    # Request handlers
│   └── Models/              # Eloquent models
├── database/
│   ├── migrations/          # Database structure
│   └── seeders/             # Sample data
├── resources/
│   └── views/               # Blade templates
├── routes/
│   └── web.php              # Web routes
└── public/                  # Public assets
```

---

## Key Models

| Model | Description |
|-------|-------------|
| `User` | Supports admin, staff, and client roles |
| `Ticket` | Core support ticket with status, priority, and assignments |
| `TicketComment` | Threaded comments on tickets |
| `Category` | Ticket categorization |
| `Priority` | Priority levels for tickets |
| `Tag` | Flexible tagging system |
| `Attachment` | File attachments for tickets |
| `SlaLog` | SLA compliance tracking |
| `Notification` | User notification system |

---

## Default Routes

| Route | Description |
|-------|-------------|
| `/login` | User login page |
| `/register` | User registration |
| `/dashboard` | Role-specific dashboard |
| `/tickets` | Ticket listing and management |
| `/users` | User management (admin only) |

---

## Running Tests

```bash
php artisan test
```

---

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## Acknowledgments

- Built with [Laravel](https://laravel.com)
- Styled with [TailwindCSS](https://tailwindcss.com)
