<?php

try {
    $db = new PDO('sqlite:database/database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = file_get_contents('database/setup.sql');
    $statements = explode(';', $sql);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            $db->exec($statement);
        }
    }
    
    echo "Database setup completed successfully!\n";
    echo "Sample products have been added.\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}