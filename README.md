# Project Setup Instructions

## Prerequisites

Before you begin, ensure you have met the following requirements:

- You have installed PHP version 8.3.0.
- You have installed Composer version 2.6.5.

## Setup Steps

Follow these steps to set up the project:

1. **Clone the Project from GitHub**

    Open your terminal and run the following command to clone the project:

    ```bash
    git clone <repository_url>
    ```

    Replace `<repository_url>` with the URL of the GitHub repository you want to clone.

2. **Install Dependencies**

    Navigate to the project directory and run the following command to install the required dependencies:

    ```bash
    composer install
    ```

3. **Create a Database**

    Create a new database in your database management system. The exact command will depend on the system you're using.

4. **Configure Environment Variables**

    Open the `.env` file in your project directory and fill in your database credentials. These will typically include the database name, host, port, username, and password.

5. **Run Database Migrations and Seed Data**

    Run the following command to migrate the database schema and seed data:

    ```bash
    php artisan migrate:fresh --seed
    ```

6. **Optimize the Application**

    Run the following command to optimize the application:

    ```bash
    php artisan optimize
    ```

7. **Start the Application**

    Finally, run the following command to start the application:

    ```bash
    php artisan serve
    ```

    This will start the application and make it accessible at `http://localhost:8000` (or another port if specified).

Please replace `<repository_url>` with the actual URL of your GitHub repository. Always double-check your commands before executing them. If you encounter any issues, please let me know so I can assist you further. Happy coding!
