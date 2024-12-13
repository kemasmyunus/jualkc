<?php
include('koneksi.php');
$response = ['status' => 'error', 'message' => 'Unknown error'];

if (!isset($_SESSION['user_id'])) {
    $response['message'] = 'User not authenticated.';
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $message = trim($_POST['message']);
    $receiver_id = $_POST['receiver_id'];

    if (empty($message)) {
        $response['message'] = 'Message cannot be empty.';
        echo json_encode($response);
        exit;
    }

    // Insert message into database
    $stmt = $pdo->prepare("INSERT INTO messages (user_id, message, receiver_id) VALUES (:user_id, :message, :receiver_id)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':receiver_id', $receiver_id);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Message sent successfully.';
    } else {
        $response['message'] = 'Failed to send message.';
    }
}

echo json_encode($response);
