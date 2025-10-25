# 🎟️ TicketApp (Twig / PHP)

A full-featured **ticket management web app** built with **PHP 8 + Twig + Dotenv**, matching the React and Vue implementations for the HNG13 Frontend Stage 2 task.

This version uses **server-rendered templates**, persistent storage via JSON, and simulated authentication using PHP sessions — all while maintaining the same layout, design tokens, and validation rules as the SPA versions.

---

## 🚀 Features

- **Consistent Layout & Design**
  - Wavy hero background and decorative circles
  - 1440 px centered layout, responsive across devices
  - Shared `tokens.css` for colors, shadows, and spacing

- **Authentication**
  - Simulated login/signup with PHP sessions (`$_SESSION['ticketapp_session']`)
  - Protected routes: `/dashboard` and `/tickets`
  - Logout button clears session and redirects to home

- **Ticket Management (CRUD)**
  - Create / Read / Update / Delete tickets
  - Inline validation and flash success/error messages
  - Tickets saved persistently in `storage/tickets.json`

- **Validation Rules**
  - `title` (required, 1–120 chars)
  - `status` (required, one of `open | in_progress | closed`)
  - `description` (optional, ≤ 2000 chars)

- **Error Handling**
  - Friendly inline and toast-style messages
  - Unauthorized users are redirected to `/auth/login`
  - Descriptive messages:
    - “Your session has expired — please log in again.”
    - “Failed to load tickets. Please retry.”

- **Accessibility**
  - Semantic HTML, alt text, visible focus, color contrast compliance

---

## 🧩 Tech Stack

- **Language:** PHP 8+
- **Templating:** [Twig](https://twig.symfony.com/)
- **Environment:** [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv)
- **Data Storage:** JSON (`storage/tickets.json`)
- **Server:** PHP built-in web server (`php -S`)

---

## 🧰 Setup & Run Locally

```bash
git clone https://github.com/TheGreatWizard16/ticketapp-twig.git
cd ticketapp-twig
composer install
cd public
php -S localhost:8080
