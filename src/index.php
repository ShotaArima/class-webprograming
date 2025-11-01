<?php
echo "<h1>Hello from PHP-FPM!</h1>";
echo "Database Host: " . (getenv('DB_HOST') ?? 'N/A');
phpinfo();
?>