<?php
    require_once('conn.php');
    function generateToken() {
        $token = '';
        for($i=0; $i<=15; $i++) {
            $token .= chr(rand(65, 90)); // A~Z 隨便組 
        }
        return $token;
    }
    function getUsernameFromCookie($token) {
        // 改用 token 去看
        global $conn; // 特殊用法
        $username = 0;
        // 用 token 去查 token 資料
        $sql = sprintf("SELECT username FROM token WHERE token = '%s'", $token);
        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            $username = $row['username'];
        }
        return $username;
    }