<?php
    require_once('./conn.php');
    require_once('utils.php');
    if (
        empty($_POST['id'])
        || empty($_POST['auth'])
    ) {
        $failure = [
            'status' => 'parms lack'
        ];
        header('Content-Type: application/json');
        echo json_encode($failure);
        return;
    }
    // update
    $stmt = $conn->prepare("UPDATE Jamie_users SET auth = ?
    WHERE id = ?");
    $stmt->bind_param("si", $_POST['auth'], $_POST['id']);
    $result = $stmt->execute();
    if (!empty($result)) {
        $success = [
            'status' => 'success'
        ];
        header('Content-Type: application/json');
        echo json_encode($success);
        return;
    }
    $failure = [
        'status' => 'failure',
        'msg' => 'sql error'
    ];
    header('Content-Type: application/json');
    echo json_encode($failure);

