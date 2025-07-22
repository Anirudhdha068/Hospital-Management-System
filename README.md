# Hospital-Management-System

# 🏥 Hospital Management System (HMS)

A modern, mobile‑friendly PHP (vanilla + MySQL) web application that streamlines every major hospital workflow—from patient registration and appointments to billing and staff management.


---

## ✨ Key Features

| Module | Highlights |
|--------|------------|
| **Public Site** | Home, Facilities, About, Contact |
| **Authentication** | Register, Login, Forgot Password |
| **Patient Portal** | Book Appointment, My Appointments, Profile & Edit Profile |
| **Admin Dashboard** | Manage Patients, Manage Staff (Add / Edit / History), Appointments (All & Today), Billing with Razorpay gateway |
| **Billing** | Generate invoices, view history |
| **Responsive UI** | Works on desktops, tablets, and phones |

All core screens are captured in *Screenshots* and listed below. :contentReference[oaicite:0]{index=0}

---

## 📸 Screenshots PDF
[Hospital Management System Screenshots PDF](Screenshots.pdf)

---

## 🛠️ Tech Stack

| Layer | Tech |
|-------|------|
| **Front‑end** | HTML5, CSS3, Bootstrap 5, vanilla JS |
| **Back‑end** | PHP 8.x (native), MySQL 8.x |
| **Payments** | Razorpay Checkout v2 |
| **Email** | PHPMailer (SMTP) for confirmations & invoices |
| **Server** | Apache 2.4 (XAMPP / Laragon) |

---
## 🧑‍💼 Default Passwords
| Role    | Email                                               | Password   |
| ------- | --------------------------------------------------- | ---------- |
| Admin   | [admin@gmail.com.com](mailto:admin@hms.com)               | admin   |
| User | [aaa@egmail.com](mailto:john.doe@example.com) | 1234567890 |
| User | [bbb@egmail.com](mailto:john.doe@example.com) | 1234567890 |

---

### 🐬 Quick Database Setup (Laragon **or** XAMPP)

1. **Start Laragon / XAMPP** → click **MySQL → Admin** to open **phpMyAdmin**  
2. **Login credentials**  
   - **Laragon:** `user root` / `pass root`  
   - **XAMPP:** `user root` / **_no password_** (leave the field blank)  
3. Left sidebar → **New** → type **`hms`** → **Create**  
4. Open the new DB → **Import** tab → choose **`hms.sql`** → **Go** — done! ✅  

> **XAMPP users:** the sample config files in this repo use `password=root`.  
> Simply **delete the password** value or leave it empty to match XAMPP’s default.






