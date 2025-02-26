
## Requirements

**Programming Language:** PHP version 8.3.9

**Database:** MySQL version 8.0.30

**CSS Framework:** Bootstrap

> **Note:** This project is built using *native PHP*. No additional PHP framework or complex installation is required – just ensure you have PHP and MySQL installed on your system.

## How to Run Project
1. Clone this project using Git or download the zip file.
2. Open the project in your code editor.
3. Open the `controller/koneksi.php` file. Change the **values** of the following variables to match your database configuration:
   - `$server` (e.g., `"localhost"`)
   - `$user` (e.g., `"root"`)
   - `$password` (e.g., `""`)
   - `$nama_database` (e.g., `"data_karyawan"`)
4. Run the project with the following command:
   
   ```bash
   php -S localhost:8000
   ```

## Steps to Import Database

### Using phpMyAdmin
1. Open phpMyAdmin and select the target database.
2. Click the **Import** tab.
3. Browse and select the SQL file from the "database" folder in this PHP project.
4. Click **Import** to start the import.

### Using MySQL Workbench
1. Open MySQL Workbench and log in to the database server.
2. Go to **Server** > **Data Import**.
3. Browse and select the SQL file from the "database" folder in this PHP project.
4. Select the target database or create a new one.
5. Click **Start Import**.
