# Job Tracker
Job Tracker is a web app created using HTML, CSS, PHP, and MySQL. Users can login / register and track how many jobs they applied to for a recruiting season.

# Initial Set up
## 1. Install Homebrew (if not already installed)

Homebrew is a package manager for macOS. Open Terminal and run:

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```
## 2. Install PHP

Once Homebrew is installed, install PHP
```bash
brew install php
```

## 3. Install mySQL / mySQL Workbench
```
brew install mysql
```
```
brew install --cask mysqlworkbench
```

Start the mySQL Service
```
brew services start mysql
```

Verify its working
```
mysql -u root -p
```

## 4. Create a local database in either mySQL Workbench (preferred) or by doing in command line
```
CREATE DATABASE job_tracker;
```
## 5. Create a .env file in the root of the project of where you cloned the repo
```
touch .env
```

Then only add these 4 lines of text in the .env
```
DB_HOST=localhost
DB_NAME={whatever you named your database}
DB_USER=root
DB_PASS={whatever your password is for the database}
```

## 6. Start the PHP bulit-in server
Navigate to the project folder where you cloned the repo.

Then we need to start the server
```bash
php -S localhost:8000
```

## 7. Open the project in any web browser
With the server running, open any browser and go to:
```bash
http://localhost:8000/views/login.php
```
