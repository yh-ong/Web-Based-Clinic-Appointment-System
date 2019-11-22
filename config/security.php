<?php
function escape_input($data)
{
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

function attempt_fail() {
    global $conn;
    $ip_add = $_SERVER["REMOTE_ADDR"];
    $stmt = $conn->prepare("INSERT INTO ip (address, timestamp) VALUES (?, ?)");
    $stmt->bind_param("ss", $ip_add, CURRENT_TIMESTAMP);
    $stmt->execute();

    $stmt1 = $conn->prepare("SELECT COUNT(*) FROM ip WHERE address LIKE ? AND timestamp > (NOW() - INTERVAL 10 MINUTE)");
    $stmt1->bind_param("s", $ip_add);
    $stmt1->execute();
    $result = $stmt1->get_result();
    $count = $result->fetch_assoc(MYSQLI_NUM);

    if ($count[0] > 3) {
        echo "Your are allowed 3 attempts in 10 minutes";
    }
}