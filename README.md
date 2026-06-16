# SLeClear MIS

**Sierra Leone Student Clearance and Financial Management Information System**

A web-based platform designed to digitize and streamline the student financial clearance process in Sierra Leonean higher institutions — eliminating manual paperwork, improving transparency, and reducing barriers to academic progression.

---

## SDG Alignment

| SDG | Target | How SLeClear Addresses It |
|---|---|---|
| **SDG 4** — Quality Education | 4.1, 4.3 | Removes financial-administrative barriers blocking students from exams, graduation, and academic records |
| **SDG 10** — Reduced Inequalities | 10.2 | Transparent, role-based digital clearance system accessible to all registered students regardless of location |

---

## Features

| Module | Description |
|---|---|
| 🎓 **Student Registry** | Register and manage full student profiles with department, faculty, level, and academic year |
| 💰 **Fee Payments** | Record tuition payments with receipts, methods (Cash, Bank Transfer, Mobile Money, Cheque), and auto-balance calculation |
| ✅ **Clearance Management** | Automated clearance when fees are fully paid; manual overrides by Finance/Admin with audit trail |
| 📋 **Deferred Assessments** | Submit and approve exam deferral applications with supporting document uploads |
| 📊 **Reports & Exports** | Export Students, Payments, and Clearance data as downloadable CSV datasets |
| 👤 **User Administration** | Create and manage system accounts with role-based access control (Admin, Finance, Registry) |
| 🌐 **JSON Data API** | Read-only interoperability API for integration with national EMIS or third-party systems |

---

## Technology Stack

| Component | Technology |
|---|---|
| Language | PHP 8.x |
| Database | SQLite3 (via PDO) |
| Frontend | HTML5, Vanilla CSS, JavaScript |
| Icons | Font Awesome 6 |
| Fonts | Google Fonts (Inter, Outfit) |
| Charts | Chart.js |
| License | MIT (Open Source) |

---

## Security Features

- **CSRF Protection** — All state-changing forms carry verified CSRF tokens
- **Session Timeout** — Automatic logout after 15 minutes of inactivity
- **Bcrypt Password Hashing** — All passwords stored with `PASSWORD_BCRYPT`
- **Role-Based Access Control** — Admin, Finance, and Registry roles with distinct permissions
- **PDO Prepared Statements** — All database queries use parameterized statements
- **Database Transactions** — Payment recording and clearance checks wrapped in atomic transactions
- **Audit Log** — Full activity log including failed login attempts with IP addresses
- **Input Validation** — Email format (`filter_var`), Sierra Leone phone regex, numeric assertions

---

## Installation & Setup

### Requirements
- PHP 8.0 or higher
- PHP PDO SQLite extension enabled
- Web server (Apache, Nginx, or PHP built-in server)

### Quick Start

```bash
# 1. Clone the repository
git clone https://github.com/YOUR_USERNAME/sleclear-mis.git
cd sleclear-mis

# 2. Verify PDO SQLite is available
php -r "echo extension_loaded('pdo_sqlite') ? 'OK' : 'MISSING';"

# 3. Start the development server
php -S localhost:8000

# 4. Open in browser
# http://localhost:8000
```

> The SQLite database is automatically created at `data/sleclear.db` on first run with default user accounts.

### Default Login Credentials

| Role | Username | Password |
|---|---|---|
| Admin | `admin` | `admin123` |
| Finance | `finance` | `finance123` |
| Registry | `registry` | `registry123` |

> ⚠️ **Change all default passwords before deploying to production.**

---

## Role Permissions Matrix

| Page / Action | Admin | Finance | Registry |
|---|---|---|---|
| Dashboard | ✅ | ✅ | ✅ |
| View Students | ✅ | ❌ | ✅ |
| Register / Edit Students | ✅ | ❌ | ✅ |
| Delete Students | ✅ | ❌ | ❌ |
| Record Payments | ✅ | ✅ | ❌ |
| View Payments | ✅ | ✅ | ❌ |
| Override Clearance Status | ✅ | ✅ | ❌ |
| View Clearances | ✅ | ✅ | ✅ |
| Print Clearance Slip | ✅ | ✅ | ✅ |
| Apply for Exam Deferral | ✅ | ✅ | ✅ |
| Approve / Deny Deferrals | ✅ | ✅ | ❌ |
| Export Reports (CSV) | ✅ | ✅ | ❌ |
| Manage User Accounts | ✅ | ❌ | ❌ |
| JSON Data API | ✅ | ✅ | ✅ (limited) |

---

## JSON Interoperability API

SLeClear exposes a read-only JSON API for integration with national EMIS platforms or third-party tools. Requires an active authenticated session.

| Endpoint | Description |
|---|---|
| `GET /api/data.php?resource=summary` | System-wide statistics snapshot |
| `GET /api/data.php?resource=students` | Paginated student list with balances |
| `GET /api/data.php?resource=payments` | Paginated payments ledger |
| `GET /api/data.php?resource=clearances` | Clearance registry (filterable by `?status=Cleared`) |

**Example Response — Summary:**
```json
{
  "resource": "summary",
  "system": "SLeClear MIS — Sierra Leone Student Clearance & Financial MIS",
  "totals": {
    "students": 42,
    "payments": 88,
    "collected_leones": 450000.00,
    "outstanding_leones": 72000.00
  },
  "clearance_breakdown": {
    "Cleared": 30,
    "Pending": 10,
    "Provisional": 2
  },
  "sdg_alignment": {
    "SDG_4": "Quality Education — Removing financial barriers to academic progression",
    "SDG_10": "Reduced Inequalities — Transparent, accessible clearance for all students"
  }
}
```

---

## Data Exports (CSV)

| Export | Route |
|---|---|
| Students Master Registry | `/api/export.php?type=csv&report=students` |
| Payments Ledger | `/api/export.php?type=csv&report=payments` |
| Clearance Registries | `/api/export.php?type=csv&report=clearances` |

---

## Project Structure

```
sleclear-mis/
├── api/
│   ├── login.php          # Authentication handler
│   ├── logout.php         # Session destruction
│   ├── students.php       # Student CRUD API
│   ├── payments.php       # Payments recording API (transactional)
│   ├── clearances.php     # Clearance override API
│   ├── deferred.php       # Deferral submission & review API
│   ├── export.php         # CSV export handler
│   └── data.php           # JSON interoperability API
├── assets/
│   ├── css/style.css      # Full design system
│   └── js/app.js          # Client-side interactions
├── config/
│   └── database.php       # SQLite connection & schema initializer
├── data/
│   └── sleclear.db        # SQLite3 database (auto-created)
├── includes/
│   ├── auth.php           # Session, CSRF, role guards
│   ├── functions.php      # Utility functions & business logic
│   ├── header.php         # Site layout header & navigation
│   └── footer.php         # Site layout footer
├── pages/
│   ├── dashboard.php      # Main analytics dashboard
│   ├── students.php       # Students list with pagination
│   ├── student_form.php   # Student registration/edit form
│   ├── payments.php       # Payments ledger with pagination
│   ├── payment_form.php   # Record payment form
│   ├── clearances.php     # Clearance registry & overrides
│   ├── clearance_view.php # Printable clearance certificate
│   ├── deferred.php       # Deferred exam applications
│   ├── deferred_form.php  # Deferral application form
│   ├── reports.php        # Reports & CSV exports console
│   ├── users.php          # User administration (Admin only)
│   └── profile.php        # User profile & password change
├── uploads/
│   └── deferred/          # Uploaded supporting documents
├── index.php              # Login portal
├── LICENSE                # MIT License
└── README.md              # This file
```

---

## Privacy & Legal Compliance

- Student personal data (names, emails, phone numbers) is stored locally in a SQLite database — no data is transmitted to external third-party services.
- Access is strictly role-controlled; unauthorized users cannot access or modify records.
- All sessions expire after 15 minutes of inactivity.
- Uploaded documents (medical certificates, etc.) are stored server-side with randomized filenames.
- The system is designed in alignment with Sierra Leone's Data Protection Act principles.

---

## License

This project is licensed under the **MIT License** — see the [LICENSE](LICENSE) file for details.

---

## Acknowledgements

Developed as a prototype for Sierra Leone higher education institutions to address student clearance inefficiencies, in support of the United Nations Sustainable Development Goals 4 and 10.
