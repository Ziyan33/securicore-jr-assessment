<?php
require 'db.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$id = $_POST['id'] ?? 0; // Assuming each weather record has a unique ID

switch ($action) {
    case 'delete':
        $stmt = $pdo->prepare("DELETE FROM weather WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['status' => 'success', 'message' => 'Record deleted successfully']);
        break;
    
    case 'update':
        $city = $_POST['city'];
        $temperature = $_POST['temperature'];
        $description = $_POST['description'];
        $stmt = $pdo->prepare("UPDATE weather SET city=?, temperature = ?, description = ? WHERE id = ?");
        $stmt->execute([$city,$temperature, $description, $id]);
        echo json_encode(['status' => 'success', 'message' => 'Record updated successfully']);
        break;
    
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}
?>
