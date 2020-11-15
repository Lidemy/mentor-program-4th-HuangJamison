<?php
    require_once('./conn.php');
    if (
        empty($_POST['nickname']) ||
        empty($_POST['username']) ||
        empty($_POST['password'])
    ) {
        header('Location: index.php?error=1');
        exit();
    }
    $nickname = $_POST['nickname'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = sprintf("INSERT INTO Jamie_users(nickname,username,password) 
    values('%s', '%s', '%s')", $nickname, $username, $password);
    $result = $conn->query($sql);
    if (!$result) {
        $fail = [
            'status' => 'fail',
            'reason' => 'sql reason',
        ];
        if ($conn->errno == 1062) {
            $fail['reason'] = 'duplicate key!!';
        }
        header('Content-Type: application/json');
        echo json_encode($fail);
        exit();
    }

    $success = [
        'status' => 'success'
    ];
    header('Content-Type: application/json');
    echo json_encode($success);