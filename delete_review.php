<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_id'])) {
    $file = 'reviews.json';
    $reviews = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $id = intval($_POST['review_id']);
    if (isset($reviews[$id])) {
        array_splice($reviews, $id, 1);
        file_put_contents($file, json_encode($reviews, JSON_PRETTY_PRINT));
    }
}
header('Location: customer_dashboard.php');
exit; 