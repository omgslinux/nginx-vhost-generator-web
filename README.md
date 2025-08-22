# Nginx Vhost Manager

After the initial project https://github.com/omgslinux/nginx-vhost-generator, based on bash scripting, here's the evolution of the same idea, but now with a web interface.

The web application is built with **Symfony**, and uses UX Live Components magic for the visual and intuitive management of Nginx Virtual Host (Vhost) configurations. It provides a simple web interface to define server parameters and create Vhosts for Nginx, with a separate console command for publishing these configurations to your Nginx server.

## Features

  * **Web-Based Interface**: A clean and easy-to-use web UI to define and manage all aspects of your Nginx Vhosts.
  * **Default Parameters**: Start by setting common server parameters such as domain suffixes, SSL certificate paths, and log formats, which are then used as a baseline for new Vhosts.
  * **Predefined Vhost Types**: The system uses a set of Vhost Types with pre-configured templates and parameters tailored for specific application purposes (e.g., a simple PHP app, a reverse proxy, a static site).
  * **Real-time Preview**: As you create and adjust a Vhost's parameters, you get a live, real-time preview of the Nginx configuration file.
  * **Database Agnostic**: By default, the application uses **SQLite**, making it simple to get started without a complex database setup. It can be easily configured to use other databases as needed.
  * **Console Publishing**: A dedicated console command is used as the final step to generate and publish the Vhost configurations, ensuring a clear separation between management and deployment.

-----

## Installation

1.  **Clone the repository**:

    ```bash
    git clone https://your-repository-path.git
    cd your-project
    ```

2.  **Install PHP dependencies**:

    ```bash
    composer install
    ```

3.  **Configure your database**:
    For a default SQLite setup, no additional configuration is required. For other databases, adjust your `.env` file accordingly.

4.  **Create the database schema**:

    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

5.  **Run the web server**:

    ```bash
    symfony server:start
    ```

    The application will be accessible at `http://127.0.0.1:8000`.

-----

## Usage

### 1\. Manage Vhosts (Web Interface)

Access the web application to start the configuration process.

  * **Set Common Parameters**: Begin by defining the server's default values.
  * **Create Vhosts**: For each Vhost you need:
      * Enter a descriptive name.
      * Select a `VhostType` to load its predefined template and parameters.
      * Adjust the parameters as needed and see the live preview update instantly.
      * Save the Vhost and repeat the process until all your configurations are complete.

### 2\. Publish Vhosts (Console Command)

Once all Vhosts are configured and saved in the database, use the console command to generate the actual files and symbolic links.

  * **Generate all Vhosts**:

    ```bash
    php bin/console app:nginx:generate-vhosts
    ```

    This command will generate or update all Vhosts defined in the database. If run with superuser permissions (`sudo`), files will be created in `/etc/nginx`. Otherwise, a test directory in `var/` will be used.

  * **Generate a specific Vhost**:

    Being `my-vhost` the name given to a self-created vhost in the database, you can use

    ```bash
    php bin/console app:nginx:generate-vhosts my-vhost
    ```

  * **Simulate generation**:
    Use the `--dry-run` option to check the generation logic without affecting your system.

    ```bash
    php bin/console app:nginx:generate-vhosts --dry-run
    ```

-----

## License

This project is licensed under the **GNU General Public License v3.0 (GPLv3)**. See the `LICENSE` file for details.
