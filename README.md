# student_puzzle
Word Puzzle Game For Student

Laravel & PHP Versions
----------------------
Laravel 11
PHP 8.2.12

Database
---------
MySQL

Setup Instructions
-------------------
1. Clone the repo
    git clone https://github.com/yourname/word-puzzle-game.git

2. Install dependencies (if vendor folder not found)
    composer install

3. Environment setup
    .env 
    .ev.testing (for unit testing)

4. Update your .env with database credentials:
    APP_ENV=local
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=student_puzzle
    DB_USERNAME=root
    DB_PASSWORD=

5. Update your .env.testing with database credentials:
    APP_ENV=testing
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=student_puzzle_test   
    DB_USERNAME=root              
    DB_PASSWORD=

6. Create Databases on local
    student_puzzle - for app
    student_puzzle_test - for app unit test

7. Run migrations
    - For app database migration
        php artisan migrate
    - For test database migration
        php artisan migrate --env=testing

8. Start the app
    php artisan serve

9. For Run Unit Test
    php artisan test


Problem Statement
------------------
-Design and build a word puzzle game for students that:
-Generates a random string of letters
-Allows students to form English words from those letters
-Scores submissions based on word length
-Tracks top scores (leaderboard)

Solution Overview
-------------------

The system is built around:

Student: Custom-authenticated users for gameplay
GameSession: Tracks puzzle state for a student
Submission: Stores valid submitted words and scores
HighScore (LeaderShip): Maintains top 10 leaderboard entries
Traits: Used for reusability (puzzle generator, validation)
Services: Handles game logic (e.g. submitting, scoring)
Unit + Feature Tests: Full coverage for validation and gameplay logic

Why This Approach
-------------------
Reusable logic 
 - Traits Used in multiple service class and test classes
Separation of concerns 
 - Custom services used to implement the game score store and submission of puzzle logic handling
Scalable authentication
 - Custom student guard and middleware used for authentication which Allows flexibility vs default User model
Fast development
 - Used Laravel 11 and Blade 
Testability
 - PHPUnit with factories which covers valid/invalid paths, ensures stability
 


