# Event Management System

## Description
The **Event Management System** is a web-based application designed to simplify the management of events, participants, and locations. It supports full CRUD (Create, Read, Update, Delete) operations for these entities and enables participants to register for events. The system also incorporates an authorization mechanism to secure specific API routes, ensuring that only authorized users can perform certain actions.

## Key Features
- **CRUD Operations**: Manage events, participants, and locations efficiently.
- **Authorization**: Secure access to sensitive API routes using role-based authorization.
- **Event Participation**: Allows users to register for events with a simple and intuitive interface.
- **Responsive Design**: User-friendly UI for seamless navigation and management of event-related tasks.

## Tech Stack
- **Backend**: PHP 8.3
- **Database**: MySQL (utf8mb4_general_ci)
- **Frontend**: HTML, CSS, JavaScript
- **Software Architecture**: Model-View-Controller (MVC)


## Installation

1. **Clone the Repository**:
    ```bash
    git clone https://github.com/essa-lab/php-event-management-system
    cd php-event-management-system
    ```


2. **Configure Environment Variables**:
    Go to `config.php` file and set up the required environment variables (database credentials):
    ```bash
    host=your-database-host
    prot=database-port
    dn_name=your-database-name
    charset=charset
    ```

3. **Import the Database Schema**:
    - Locate the `tables.sql` file in the `base` folder.
    - Use the following MySQL command to import the SQL schema:
      ```bash
      mysql -u userName -p databaseName < ./tables.sql
      ```



4. **Start the Development Server**:
    To run the project locally, use:
    ```bash
    php -S localhost:8000 -t public/.
    ```
## Postman Collection

To interact with the API more easily, you can use our Postman collection, which contains pre-configured requests for all the available endpoints.

1. Download the Postman collection: [Event Management Postman Collection](./EventManagementSystem.postman_collection.json)
2. Import the collection into Postman:
    - Open Postman and click on **Import**.
    - Upload the JSON file or paste the link to the raw file in your repository.
3. Use the pre-configured requests to test the API.

## Project Structure

The following is an overview of the core project structure, explaining the roles of various files and folders within the application.

### 1. **Core Folder**
This folder contains the core logic and utilities required for the application's functionality.

- **Middleware Folder**:
  - `Middleware.php`: Responsible for resolving the registered middleware for the application.
  - `Authorized.php`: Middleware that checks if the user is authorized to perform a specific action or if the user is blocked.

- **App.php**: Resolves new instances from the container, acting as a core service handler.
- **Container.php**: Handles the binding and resolving of instances. It also supports singleton instances to avoid recreating objects multiple times.
- **Database.php**: Responsible for connecting to the database and returning the connection instance.
- **functions.php**: Contains a variety of useful helper functions.
- **Model.php**: Treats database tables as OOP objects and contains methods to query the database (e.g., `where`, `join`, `orWhere`, `select`).
- **Request.php**: Deals with the incoming request data.
- **Response.php**: Handles the response returned from the server to the client.
- **Router.php**: Registers the routes for the project and applies optional middleware to specific routes.
- **Session.php**: Manages session data.
- **Validator.php**: Validates incoming request data.

### 2. **Http Folder**
Contains the following subfolders:
- **Controller**: Houses the controllers that manage the application's business logic and interact with models.
- **Model**: Contains the models that represent the database entities.

### 3. **Public Folder**
Contains assets like scripts and styles and includes `index.php`, which serves as the entry point for the application.

### 4. **Routes Folder**
Defines all the routes for the application:
- **api.php**: Declares API routes for the application.
- **web.php**: Declares web routes for browser-based interactions.

### 5. **Views Folder**
Contains all the view files that the application uses to render the user interface.

### 6. **Bootstrap File**
- **bootstrap.php**: Binds objects to the container for `Request`, `Response`, and `Database` classes to ensure consistent access to these core services throughout the application.

### 7. **Configuration File**
- **config.php**: Contains the database credentials and other application configuration settings.


## Conclusion

The **Event Management System** is a robust and flexible solution for managing events, participants, and locations. With its intuitive user interface, secure API routes, and efficient CRUD operations, it simplifies the entire process of organizing and running events. By using modern technologies such as PHP 8.3, MySQL, and the MVC architecture, this project ensures scalability and maintainability.

Thank you for checking out the project!


