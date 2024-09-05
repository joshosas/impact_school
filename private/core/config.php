<?php

// Automatically detect if running on localhost or production
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    // Local development environment
    define('ROOT', 'http://localhost/impact_school/public');
    define('DB_NAME', 'impact_school');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'impact_school');
    define('DB_PASSWORD', '992211');
} else {
    // Production environment
    define('ROOT', 'https://impactschool.com');
    define('DB_NAME', 'your_production_db_name');
    define('DB_HOST', 'your_production_db_host');
    define('DB_USER', 'your_production_db_user');
    define('DB_PASSWORD', 'your_production_db_password');
}

define('DB_DRIVER', 'mysql');
