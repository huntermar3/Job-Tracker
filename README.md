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

## 3. Start the PHP bulit-in server
Navigate to the project folder
```bash
cd ~/JobTracker
```
Then we need to start the server
```bash
php -S localhost:8000
```

## 4. Open the project in any web browser
With the server running, open any browser and go to:
```bash
http://localhost:8000/views/login.php
```