<?php

$users = [];

$sql = "SELECT firstName, lastName, email FROM users";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("خطأ في جلب المسجلين: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

mysqli_free_result($result);

?>