# Job Tracker
Job Tracker is a web app created using HTML, CSS, PHP, and MySQL. Users can login / register and track how many jobs they applied to for a recruiting season.

# Initial Set up(MacOS)
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

## 5. Go into mySQL Workbench with the database you just made. 
At the top of your query, please type
```use job_tracker ```
Then go into root of this repo and copy structure of the tables in Job_Listing.sql. The table creation should be under "use job_tracker"

## 6. Create a .env file in the root of the project of where you cloned the repo
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

## 7. Start the PHP bulit-in server
Navigate to the project folder where you cloned the repo.

Then we need to start the server
```bash
php -S localhost:8000
```

## 8. Open the project in any web browser
With the server running, open any browser and go to:
```bash
http://localhost:8000/views/login.php
```

# Initial Set up(Windows 7 or later)
## 1. Install Chocolately (if not already installed)

Chocolately is an open-source software package manager for Windows that automates the installation, upgrading, and removal of software, similar to package managers in Linux and macOS. 
Open Command Prompt as administrator and run: 

```cmd
@"%SystemRoot%\System32\WindowsPowerShell\v1.0\powershell.exe" -NoProfile -InputFormat None -ExecutionPolicy Bypass -Command " [System.Net.ServicePointManager]::SecurityProtocol = 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))" && SET "PATH=%PATH%;%ALLUSERSPROFILE%\chocolatey\bin"
```

## 2. Install PHP

Once Chocolately is installed, install PHP
```cmd
choco install php
```

## 3. Install mySQL / mySQL Workbench
```cmd
choco install mysql
```
```cmd
choco install --cask mysqlworkbench
```

## 4. Create a local database in either mySQL Workbench (preferred) or by doing in command line
```
CREATE DATABASE job_tracker;
```

## 5. Go into mySQL Workbench with the database you just made. 
At the top of your query, please type
```use job_tracker ```
Then go into root of this repo and copy structure of the tables in Job_Listing.sql. The table creation should be under "use job_tracker"

## 6. Create a .env file in the root of the project of where you cloned the repo
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

## 7. Start the PHP bulit-in server
Navigate to the project folder where you cloned the repo.

Then we need to start the server
```cmd
php -S localhost:8000
```

## 8. Open the project in any web browser
With the server running, open any browser and go to:
```
http://localhost:8000/views/login.php
```
