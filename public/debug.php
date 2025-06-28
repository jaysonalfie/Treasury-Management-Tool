<?php
// Simple Laravel debug file - save this as public/debug.php

echo "<h1>Laravel Debug Information</h1>";

// Check if Laravel is loaded
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    echo "<p>✅ Vendor autoload exists</p>";
    require_once __DIR__ . '/../vendor/autoload.php';
} else {
    echo "<p>❌ Vendor autoload missing</p>";
    die();
}

// Check if Laravel app exists
if (file_exists(__DIR__ . '/../bootstrap/app.php')) {
    echo "<p>✅ Bootstrap app exists</p>";
    try {
        $app = require_once __DIR__ . '/../bootstrap/app.php';
        echo "<p>✅ Laravel app loaded</p>";
    } catch (Exception $e) {
        echo "<p>❌ Laravel app failed to load: " . $e->getMessage() . "</p>";
        die();
    }
} else {
    echo "<p>❌ Bootstrap app missing</p>";
    die();
}

// Check environment variables
echo "<h2>Environment Variables:</h2>";
echo "<p>APP_ENV: " . (getenv('APP_ENV') ?: 'NOT SET') . "</p>";
echo "<p>APP_DEBUG: " . (getenv('APP_DEBUG') ?: 'NOT SET') . "</p>";
echo "<p>APP_KEY: " . (getenv('APP_KEY') ? 'SET' : 'NOT SET') . "</p>";
echo "<p>DATABASE_URL: " . (getenv('DATABASE_URL') ? 'SET' : 'NOT SET') . "</p>";
echo "<p>DB_CONNECTION: " . (getenv('DB_CONNECTION') ?: 'NOT SET') . "</p>";

// Check directories
echo "<h2>Directory Permissions:</h2>";
echo "<p>Storage writable: " . (is_writable(__DIR__ . '/../storage') ? 'YES' : 'NO') . "</p>";
echo "<p>Bootstrap cache writable: " . (is_writable(__DIR__ . '/../bootstrap/cache') ? 'YES' : 'NO') . "</p>";

// Check .env file
echo "<h2>Environment File:</h2>";
if (file_exists(__DIR__ . '/../.env')) {
    echo "<p>✅ .env file exists</p>";
} else {
    echo "<p>❌ .env file missing</p>";
}

// Try to boot Laravel
echo "<h2>Laravel Boot Test:</h2>";
try {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo "<p>✅ Laravel kernel created</p>";
    
    $request = Illuminate\Http\Request::capture();
    echo "<p>✅ Request captured</p>";
    
    // This is where it might fail
    $response = $kernel->handle($request);
    echo "<p>✅ Laravel fully booted</p>";
} catch (Exception $e) {
    echo "<p>❌ Laravel boot failed: " . $e->getMessage() . "</p>";
    echo "<p>Stack trace: " . $e->getTraceAsString() . "</p>";
}

echo "<p>Debug completed at " . date('Y-m-d H:i:s') . "</p>";
?>