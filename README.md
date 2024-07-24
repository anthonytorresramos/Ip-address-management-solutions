## IP Address Management System

### Introduction

This project is an IP Address Management System built with Laravel and Vue.js. It includes features for managing IP addresses and audit logging for tracking changes.

### Tech Stack

-   **Backend**: Laravel 10.x
-   **Frontend**: Vue 3 with Composition API
-   **Authentication**: Laravel Jetstream with Sanctum
-   **Testing**: Pest PHP

### Features

-   Manage IP addresses with optional labels.
-   Track changes to IP addresses and labels via audit logs.
-   Ensure IP addresses are unique.
-   Fetch and filter audit logs by user and IP address.
-   Responsive UI with Vue 3 and Tailwind CSS.

### Installation

1.  **Clone the Repository**

```bash
git clone https://github.com/anthonytorresramos/Ip-address-management-solutions.git
cd ip-management-solution
```

2. **Install Dependencies**

```bash
composer install
npm install
```

3. **Setup Environment**

-   Copy the `.env.example` to `.env` and configure the database and other necessary settings.

```
cp .env.example .env
```

4. **Run Migrations**
   `php artisan migrate`

5. **Serve the Application**

```bash
php artisan serve
npm run dev or npm run build
```

### Usage

#### Frontend

1.  **Access the Application**

    -   Open your browser and go to `http://localhost:8000` to see the application.

2.  **Managing IP Addresses**

    -   Navigate to the "IP Management" section.
    -   Use the "Create New Entry" button to add a new IP address.
    -   Update label but not ip address

3.  **Viewing Audit Logs**

    -   Navigate to the "Audit Logs" section.
    -   Filter logs by user or IP address.
    -   Sort logs by columns to see the changes in detail.

#### Running Pest Tests

1.  **Run Tests**

    -   Ensure you have the testing environment configured in your `.env` file.
    -   Run the following command to execute tests

```bash
php artisan test tests/CustomTests
```

**Expected Results**

-   All tests should pass with no errors.
-   The test suite includes:
    -   it can create an IP management entry
    -   it ensures ip_address is unique
    -   it can update an IP management entry with optional label and ensure ip_address is unchanged
    -   it can fetch IP management entries
    -   it can fetch audit logs
    -   it can fetch audit logs by user
    -   it can fetch audit logs by ip address

#### API Routes

```php
These are the routes defined in `api.php`:
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/ip-management', [IpManagementController::class, 'index']);
    Route::post('/ip-management', [IpManagementController::class, 'store']);
    Route::put('/ip-management/{id}', [IpManagementController::class, 'update']);
    Route::get('/audit-logs', [IpManagementController::class, 'getAllAuditLogs']);
    Route::get('/audit-logs/user/{userId}', [IpManagementController::class, 'getAuditLogsByUser']);
    Route::get('/audit-logs/ip-address/{ipManagementId}', [IpManagementController::class, 'getAuditLogsByMacAddress']);
});
```
