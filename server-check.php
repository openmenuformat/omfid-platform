<?php
// Create this as: omfid.com/server-check.php
// Visit it to see what's happening on your server

echo "<h2>🔍 OMFID Server Diagnostics</h2>";

echo "<h3>PHP Environment</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";

echo "<h3>Apache Modules</h3>";
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    echo "mod_rewrite: " . (in_array('mod_rewrite', $modules) ? '✅ ENABLED' : '❌ DISABLED') . "<br>";
    echo "All modules: " . implode(', ', $modules) . "<br>";
} else {
    echo "Cannot check Apache modules (not running under Apache or function disabled)<br>";
}

echo "<h3>File Permissions Check</h3>";
$files = ['.htaccess', 'index.php', 'view.php'];
foreach ($files as $file) {
    if (file_exists($file)) {
        $perms = substr(sprintf('%o', fileperms($file)), -4);
        echo "$file: EXISTS (permissions: $perms)<br>";
    } else {
        echo "$file: ❌ MISSING<br>";
    }
}

echo "<h3>Request Information</h3>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "Script Name: " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "Query String: " . ($_SERVER['QUERY_STRING'] ?? 'none') . "<br>";

echo "<h3>URL Rewrite Test</h3>";
echo "If you see this page at omfid.com/server-check.php, direct file access works.<br>";
echo "Try visiting: omfid.com/test-rewrite<br>";
echo "If that shows this page, URL rewriting is working.<br>";

echo "<h3>Supabase Connection Test</h3>";
// Test if your Supabase function works
if (function_exists('curl_init')) {
    echo "cURL: ✅ Available<br>";
    
    // Test a simple Supabase query
    $SUPABASE_URL = "https://au.openmenuformat.com";
    $SUPABASE_ANON_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtpem5jbnBodHJmbXZmeXB3c3ZiIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzQ3MDU5MDQsImV4cCI6MjA1MDI4MTkwNH0.pjBXIE317d6cFbwaDJwBVmhNXcRU2TnwbhS9jCOhrvc";
    
    $url = "$SUPABASE_URL/rest/v1/business?select=omfid_slug&limit=1";
    $headers = [
        "apikey: $SUPABASE_ANON_KEY",
        "Authorization: Bearer $SUPABASE_ANON_KEY"
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "Supabase Response Code: $httpCode<br>";
    if ($httpCode === 200) {
        echo "Supabase: ✅ CONNECTED<br>";
        echo "Sample data: " . substr($response, 0, 100) . "...<br>";
    } else {
        echo "Supabase: ❌ CONNECTION FAILED<br>";
    }
} else {
    echo "cURL: ❌ NOT AVAILABLE<br>";
}
?>