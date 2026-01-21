# Rantget Property Rental Management System

## Overview

Rantget is a Laravel-based web application that facilitates property rental transactions between landlords and tenants. It manages the complete rental lifecycle—from property listing and contract creation to monthly payment tracking—while enforcing role-based access control.

This README provides a high-level introduction to the system's purpose, core entities, user roles, architecture, and feature modules.

---

## Purpose & Scope

The system is designed to:

* Enable landlords to list and manage rental properties.
* Allow tenants to browse, rent, and pay for properties.
* Support administrators in overseeing all system operations.
* Maintain an audit trail for all contract changes.

Rantget supports a **dual-role user model**, allowing a single user to act as both landlord and tenant simultaneously. All contract updates and deletions are logged via the `History` model for compliance and traceability.

---

## Core Domain Entities

| Model    | Primary Key | Purpose                                         | Key Relationships                                               |
| -------- | ----------- | ----------------------------------------------- | --------------------------------------------------------------- |
| User     | id          | Represents landlords, tenants, and admins       | Has many contracts, belongs to many properties                  |
| Property | id          | Real estate assets available for rent           | Belongs to many users (via `property_user`), has many contracts |
| Contract | id          | Rental agreements linking properties to tenants | Belongs to property, landlord, tenant; has many payments        |
| Payment  | id          | Monthly payment transactions                    | Belongs to contract; tracked by month and year                  |
| History  | id          | Audit trail for contract modifications          | Belongs to contract and user; stores JSON snapshots             |

---

## User Roles & Capabilities

### Admin (`is_admin = true`)

* Full access to all system features.
* Assigned via a boolean `is_admin` column on the User model.
* Special backdoor: any user registering with `admin@gmail.com` automatically becomes admin.

### Landlord (`role = 'landlord'`)

* Manage property listings.
* Create and manage rental contracts.
* View tenants renting their properties.
* Monitor payment status across contracts.
* Access audit history.

Route prefix: `/landlord/*`

### Tenant / Renter (`role = 'tenant'` or `'renter'`)

* Browse available properties.
* Initiate rental contracts.
* View rented properties and payment status.
* Submit monthly payments.

Route prefix: `/renter/*`

---

## System Architecture

The application follows Laravel’s **MVC architecture** with four layers:

| Layer          | Components                      | Purpose                                        |
| -------------- | ------------------------------- | ---------------------------------------------- |
| Presentation   | Blade templates, views          | Renders HTML for user interaction              |
| Application    | Controllers, middleware, routes | Handles HTTP requests and business logic       |
| Domain         | Eloquent models                 | Represents business entities and relationships |
| Infrastructure | Database, file storage, session | Provides persistence and framework services    |

Key files:

* Routing: `routes/web.php`
* Controllers: `app/Http/Controllers/*`
* Models: `app/Models/{User,Property,Contract,Payment,History}.php`
* Views: `resources/views/*`

---

## Feature Modules

### Property Management

* Full CRUD via `PropertiesController`.
* Properties support four states: `available`, `unavailable`, `reserved`, `rent`.
* Properties are linked to landlords via the `property_user` pivot table.

### Contract Management

* Managed via `ContractsController`.
* Includes:

  * Validation of rental periods.
  * File upload for contract documents.
  * Automatic history logging on update and delete.
  * Conversion of `penalty_amount` from yes/no to boolean.

### Payment Tracking

* Managed via `PaymentsController`.
* Tracks monthly payments with:

  * Month and year fields.
  * Amount, payment method, last 4 card digits.
  * Status (`paid`, `late`, `unpaid`).
* Automatically computes payment status across contract duration.

---

## Authentication & Authorization

* Uses Laravel’s session-based authentication.
* Role-based redirection after login based on `is_admin` and `role`.
* All `/landlord/*` and `/renter/*` routes are protected by `auth` middleware.
* Public access is allowed for property browsing.

---

## Data Relationships

The `property_user` pivot table enables many-to-many relationships between users and properties, with a `role` column to distinguish landlords and tenants.

### Key Relationships

* User → ownedProperties(): properties where pivot role is `landlord`.
* User → rentedProperties(): properties via contracts where user is tenant.
* User → contracts(): contracts where user is landlord.
* User → tenantContracts(): contracts where user is tenant.

---

## Special Features

### Audit Trail System

All contract updates and deletions are logged to the `History` model, capturing:

* `contract_id`
* `user_id`
* `action_type` (`updated` or `deleted`)
* `old_data` (JSON snapshot)
* `new_data` (JSON snapshot or null)

### Dual-Role User Model

Users can act as both landlords and tenants, enabled by:

* The `property_user` pivot table with role distinction.
* Separate foreign keys on `Contract` (`landlord_id`, `tenant_id`).
* Distinct relationship methods on the User model.

### Admin Backdoor

Any user registering with the email `admin@gmail.com` automatically receives admin privileges (`is_admin = true`).

---

## Request Flow Summary

1. **Route Matching** – Request URL matched in `routes/web.php`.
2. **Middleware Chain** – `auth` middleware validates session; role middleware checks permissions.
3. **Controller Dispatch** – Matched controller method executes.
4. **Model Interaction** – Controller queries/persists via Eloquent models.
5. **View Rendering** – Data passed to Blade templates.
6. **Response** – HTML or redirect returned to browser.

---

## Installation & Setup

### Prerequisites

* PHP ^8.2
* Composer
* Node.js & npm
* MySQL or compatible database

### Setup Steps

```bash
# 1. Clone the repository
git clone <your-repo-url>
cd rantget

# 2. Install backend dependencies
composer install

# 3. Install frontend dependencies
npm install

# 4. Copy environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Configure database in .env
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# 7. Run migrations
php artisan migrate

# 8. (Optional) Seed database
php artisan db:seed

# 9. Build frontend assets
npm run build

# 10. Run development server
php artisan serve
```

Visit: `http://127.0.0.1:8000`

---

## API Support

> If APIs are enabled, all routes should be protected using `auth:sanctum`.

### Authentication

* `POST /api/login`
* `POST /api/logout`
* `POST /api/register`

### Core Resources

* `GET /api/properties`
* `POST /api/properties`
* `GET /api/contracts`
* `POST /api/contracts`
* `GET /api/payments`
* `POST /api/payments`

---

## Testing

```bash
php artisan test
```

Or using Pest:

```bash
./vendor/bin/pest
```

---

## Contribution Guidelines

1. Fork the repository.
2. Create a new branch: `git checkout -b feature-name`.
3. Commit your changes: `git commit -m "Add new feature"`.
4. Push to your branch: `git push origin feature-name`.
5. Open a Pull Request.

---

## License

This project is open-source and available under the **MIT License**.

---

## Additional Documentation (PDFs)

You can find detailed technical documentation in the following PDF files (place them inside a `docs/` folder in your repository):

* 📄 [Authentication & Authorization Flow](docs/Authentication%20and%20Authorization%20Flow.pdf)
* 📄 [Data Relationships / Database Design](docs/Data%20Relationships.pdf)
* 📄 [Entity to Code Mapping / MVC Structure](docs/Entity%20to%20code%20mapping.pdf)
* 📄 [Feature Module Overview / Routing System](docs/Feature%20module%20overview.pdf)


---

## Database Schema Overview

### Main Tables

#### `users`

| Column     | Type    | Description                |
| ---------- | ------- | -------------------------- |
| id         | bigint  | Primary key                |
| name       | string  | User full name             |
| email      | string  | Unique email               |
| password   | string  | Hashed password            |
| role       | string  | landlord / tenant / renter |
| is_admin   | boolean | Admin flag                 |
| timestamps | —       | Created & updated at       |

#### `properties`

| Column      | Type    | Description                               |
| ----------- | ------- | ----------------------------------------- |
| id          | bigint  | Primary key                               |
| title       | string  | Property title                            |
| description | text    | Property description                      |
| address     | string  | Property address                          |
| status      | string  | available / unavailable / reserved / rent |
| price       | decimal | Monthly rent                              |
| timestamps  | —       | Created & updated at                      |

#### `contracts`

| Column         | Type    | Description            |
| -------------- | ------- | ---------------------- |
| id             | bigint  | Primary key            |
| property_id    | bigint  | FK → properties.id     |
| landlord_id    | bigint  | FK → users.id          |
| tenant_id      | bigint  | FK → users.id          |
| start_date     | date    | Contract start         |
| end_date       | date    | Contract end           |
| penalty_amount | boolean | Penalty flag           |
| contract_image | string  | Uploaded document path |
| timestamps     | —       | Created & updated at   |

#### `payments`

| Column         | Type    | Description          |
| -------------- | ------- | -------------------- |
| id             | bigint  | Primary key          |
| contract_id    | bigint  | FK → contracts.id    |
| month          | integer | 1–12                 |
| year           | integer | Year of payment      |
| amount         | decimal | Payment amount       |
| method         | string  | Payment method       |
| card_last_four | string  | Last 4 digits        |
| status         | string  | paid / late / unpaid |
| timestamps     | —       | Created & updated at |

#### `histories`

| Column      | Type   | Description          |
| ----------- | ------ | -------------------- |
| id          | bigint | Primary key          |
| contract_id | bigint | FK → contracts.id    |
| user_id     | bigint | FK → users.id        |
| action_type | string | updated / deleted    |
| old_data    | json   | Previous snapshot    |
| new_data    | json   | New snapshot         |
| timestamps  | —      | Created & updated at |

#### `property_user` (Pivot Table)

| Column      | Type   | Description        |
| ----------- | ------ | ------------------ |
| property_id | bigint | FK → properties.id |
| user_id     | bigint | FK → users.id      |
| role        | string | landlord / tenant  |

---

## Entity Relationship Diagram (Textual)

```text
User (1) ────< owns >──── (∞) Property
   │                         │
   │                         │
   │                         └──── (∞) Contract ────< (∞) Payment
   │                                     │
   │                                     │
   └────< rents >──── (∞) Property <─────┘

User has many Contracts (as landlord)
User has many Contracts (as tenant)
Property has many Contracts
Contract has many Payments
Contract has many Histories
```

---

## Validation Rules (Example: Contracts)

```php
$request->validate([
    'property_id' => 'required|exists:properties,id',
    'landlord_id' => 'required|exists:users,id',
    'tenant_id' => 'required|exists:users,id',
    'start_date' => 'required|date',
    'end_date' => 'required|date|after:start_date',
    'penalty_amount' => 'nullable|boolean',
    'contract_image' => 'nullable|file|mimes:pdf,jpg,jpeg,png'
]);
```
*Maintained by Steven Hany Elia*
