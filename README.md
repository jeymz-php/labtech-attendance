# UCC LabTech - Real-Time Attendance Monitoring System

A Laravel-based web application for the **University of Caloocan City (UCC) - LabTech** to monitor student attendance in real-time during laboratory hours.

## 🚀 Live Site
- **URL:** [https://ucc-labtech.bsitfoura.com](https://ucc-labtech.bsitfoura.com)
- **Status:** Production (Live)

## 📋 System Overview

The system allows students to log their attendance by entering their student number. It validates attendance based on pre-configured office hours (Monday–Friday, 8:00 AM – 5:00 PM). All activities are logged in real-time for faculty monitoring.

### Key Features
- **Real-Time Attendance Logging** – Timestamped entry records.
- **Office Hours Enforcement** – Auto-blocks entries outside 8:00 AM – 5:00 PM on weekdays.
- **Live Activity Feed** – Displays recent student check-ins.
- **Current Date/Time Display** – Shows server-side Philippine Time (PHT).
- **Responsive UI** – Works on desktops, tablets, and mobiles.

## 🛠️ Tech Stack
| Component       | Technology                          |
|----------------|-------------------------------------|
| Backend        | Laravel 9.x (PHP 8.2.30)           |
| Frontend       | Blade Templates, HTML5, CSS3, JavaScript |
| Database       | MySQL (Hostinger)                   |
| Server         | Hostinger hPanel (LiteSpeed)       |
| Version Control| Git                                |

## 📁 Project Structure (Key Paths)
public_html/
├── app/ → Models, Controllers, Commands
├── bootstrap/ → Framework bootstrapping
├── config/ → Laravel configuration files
├── database/ → Migrations and seeders
├── public/ → Frontend assets (CSS, JS, images)
│ ├── index.php → Application entry point
│ └── .htaccess → URL rewriting rules
├── resources/views/ → Blade templates (UI)
├── routes/web.php → Web routes (attendance logic)
├── storage/ → Logs, session files, compiled views
└── .env → Environment variables (DB, app keys)


## 🗄️ Database Schema (Main Tables)

| Table | Purpose |
|-------|---------|
| `users` | Student & admin accounts (`role`, `student_id`, `rfid_uid`) |
| `attendances` | Logs student check-ins with timestamps |
| `office_hours_settings` | Configurable daily schedule |
| `archived_students` | Historical record of inactive students |

## 🔧 Local Development Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/labtech-attendance.git
   cd labtech-attendance

2. **Install dependencies:**
   composer install
   npm install && npm run dev   (if using frontend assets)

3. **Environment configuration:**
   cp .env.example .env
   php artisan key:generate
Update .env with your local database credentials.

4. **Run migrations & seeders:**
   php artisan migrate --seed

5. **Start the development server:**
   php artisan serve
