<?php
// ajax.php - safely include only allowed module fragments
$allowed = ['london','paris','tokyo','registration_form','payments','table','patients'];

$page = isset($_GET['page']) ? $_GET['page'] : '';

if (!in_array($page, $allowed)) {
    http_response_code(404);
    echo '<div class="card"><div class="card-body"><h5>Page not found</h5></div></div>';
    exit;
}

// include the module (module files are HTML fragments)
$modulePath = __DIR__ . "/modules/{$page}.php";
if (file_exists($modulePath)) {
    include $modulePath;
} else {
    http_response_code(500);
    echo '<div class="card"><div class="card-body"><h5>Module missing</h5></div></div>';
}
?>