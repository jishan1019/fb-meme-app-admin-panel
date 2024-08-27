<?php
include "../auth/connect.php";

$conn = connect();

function validateToken($token)
{
    $decodedToken = base64_decode($token);
    $dataCheck = 'Authorization header not found';
    return $decodedToken === $dataCheck;
}

$headers = getallheaders();
$authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

if (!$authHeader) {
    http_response_code(401);
    echo json_encode(["message" => "Authorization header not found"]);
    exit;
}

if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    $token = $matches[1];
} else {
    http_response_code(401);
    echo json_encode(["message" => "Invalid Authorization header format"]);
    exit;
}

if (!validateToken($token)) {
    http_response_code(401);
    echo json_encode(["message" => "Invalid token"]);
    exit;
}

// Initialize the base query
$sql = "SELECT * FROM memes";

// Check for query parameters and append to the SQL query
$queryParams = [];

if (isset($_GET['date'])) {
    $date = $conn->real_escape_string($_GET['date']);
    $queryParams[] = "create_at LIKE '$date%'";
}

if (isset($_GET['limit'])) {
    $limit = intval($_GET['limit']);
}

if (isset($_GET['sort'])) {
    $sortField = $conn->real_escape_string($_GET['sort']);
    $sortOrder = 'DESC'; // Default sort order
    if (isset($_GET['order']) && strtolower($_GET['order']) === 'asc') {
        $sortOrder = 'ASC';
    }
} else {
    // Default sort field
    $sortField = 'create_at';
    $sortOrder = 'DESC';
}

// Apply filters to the query
if (!empty($queryParams)) {
    $sql .= " WHERE " . implode(' AND ', $queryParams);
}

// Apply sorting to the query
$sql .= " ORDER BY $sortField $sortOrder";

// Apply limit to the query if set
if (isset($limit)) {
    $sql .= " LIMIT $limit";
}

$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    header('Content-type: application/json');
    echo json_encode($data);
} else {
    echo json_encode(["message" => "No Data found"]);
}

$conn->close();
