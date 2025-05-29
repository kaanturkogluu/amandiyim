<?php

require_once __DIR__ . '/../classes/StoreCategories.php';
require_once __DIR__ . '/../classes/Session.php';

// Set JSON header for all responses
header('Content-Type: application/json');

// Check if user is logged in and is admin
$session = Session::getInstance();
if (!$session->isLoggedIn() || !$session->isAdmin()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Initialize CampaignCategories class
$campaignCategories = new StoreCategories();

// Handle different actions
if (!isset($_POST['action'])) {
    echo json_encode(['success' => false, 'message' => 'No action specified']);
    exit;
}

switch ($_POST['action']) {
    case 'create':
        // Validate required fields
        if (!isset($_POST['category_name']) || empty($_POST['category_name'])) {
            echo json_encode(['success' => false, 'message' => 'Category name is required']);
            exit;
        }

        if (!isset($_POST['status']) || !in_array($_POST['status'], ['active', 'inactive'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid status']);
            exit;
        }

        // Create category
        $data = [
            'category_name' => trim($_POST['category_name']),
            'status' => $_POST['status']
        ];

        if ($campaignCategories->create($data)) {
            echo json_encode(['success' => true, 'message' => 'Category created successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create category']);
        }
        break;

    case 'update':
        // Validate required fields
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid category ID']);
            exit;
        }

        if (!isset($_POST['category_name']) || empty($_POST['category_name'])) {
            echo json_encode(['success' => false, 'message' => 'Category name is required']);
            exit;
        }

        if (!isset($_POST['status']) || !in_array($_POST['status'], ['active', 'inactive'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid status']);
            exit;
        }

        // Update category
        $data = [
            'category_name' => trim($_POST['category_name']),
            'status' => $_POST['status']
        ];

        if ($campaignCategories->update($_POST['id'], $data)) {
            echo json_encode(['success' => true, 'message' => 'Category updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update category']);
        }
        break;

    case 'delete':
        // Validate required fields
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid category ID']);
            exit;
        }

        // Check if category exists
        $category = $campaignCategories->find($_POST['id']);
        if (!$category) {
            echo json_encode(['success' => false, 'message' => 'Category not found']);
            exit;
        }

        // Delete category
        if ($campaignCategories->delete($_POST['id'])) {
            echo json_encode(['success' => true, 'message' => 'Category deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete category']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
