<?php
try {
    // Create (connect to) SQLite database in file
    $connectionDb = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');

    // Set errormode to exceptions
    $connectionDb->setAttribute(PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    // Print PDOException message
    echo $e->getMessage();
}