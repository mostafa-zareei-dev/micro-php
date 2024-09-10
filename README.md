# Micro PHP Framework based on MVC

Developing Micro PHP framework based on MVC using Object-Oriented programming (OOP) principles.

## Features

- **Routing:** Create and manage routes. Map URL path to specific controllers and actions.
- **Dependency Injection (DI) Container:** Manage dependencies and services. Register services and their dependencies, and retrieve them when needed.
- **Controllers:** Handle incoming requests and return responses.
- **Middlewares:** Intercepts requests for tasks such as authentication.
- **Models:** Interact with database.
- **Views:** Renders HTML templates and passes data from controllers to views.

## Directory Structure

The framework’s directory structure is as follows:

```bash
/app
  /controllers        # Controllers handle HTTP requests
  /middlewares        # Middlewares for request processing
  /models             # Models interact with the database
/config               # Configuration files
/public               # Publicly accessible files (e.g., assets, index.php)
  /assets
  index.php           # Entry point for the application
/routes               # Define routes (e.g., web.php)
  web.php             # Define web routes 
/src
  /Core               # Core components of the framework
  /Routing            # Routing logic
  /Container          # DI Container implementation
  /ServiceProviders   # Base ServiceProvider and abstract classes
  /Http               # Base Http classes
  /Controllers        # Base controllers and abstract classes
  /Middlewares        # Base middlewares and abstract classes
  /Models             # Base models and abstract classes
  /Views              # View rendering logic
/vendor                 # Composer dependencies
/views              # Views render HTML output
```

## Installation

&nbsp;&nbsp;**1. Clone the repository:**

```bash
git clone https://github.com/mostafa-zareei-dev/micro-php.git
cd micro-php
```

&nbsp;&nbsp;**2. Install dependencies:**

```bash
composer install
```

&nbsp;&nbsp;**3. Set up your web server** to point to the public directory.

## Configuration
Configuration settings are located in the /config directory. You can configure database connections, environment settings, and other application parameters here.