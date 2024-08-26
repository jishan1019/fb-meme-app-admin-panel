<?php
session_start();
include "header.php";
include "auth/connect.php";

$userEmail = $_SESSION['userEmail'];
$conn = connect();

if (empty($userEmail)) {
    header('location: login.php');
    exit();
}

$m = '';



if (isset($_POST["submit"])) {
    $passInput = mysqli_real_escape_string($conn, $_POST['pass']);
    $pass = md5($passInput);

     // Update user information
     $sql = "UPDATE users SET pass = '$pass' WHERE email = '$userEmail'";


    if ($conn->query($sql) === TRUE) {
        $m = 'User updated successfully.';
        header('location: logout.php');
    } else {
        $m = 'Error updating user: ' . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html data-theme="light" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update User</title>

    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="container mx-auto min-h-screen bg-white">
    <main class="flex justify-center items-center min-h-[40vh] sm:min-h-screen">
        <div class="card w-full max-w-xs sm:max-w-sm shrink-0 shadow-2xl">
            <div>
                <h5 class="text-2xl font-bold text-black text-center mt-8">Update Password</h5>
                <p class="text-lg font-bold text-red-500 text-center mt-8"><?php if ($m != '') echo $m; ?></p>
            </div>

            <form class="card-body" method="POST">
            

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <input name="pass" type="password" placeholder="Enter your password"
                        class="input input-bordered bg-white border-2 border-black/20 text-black" required />
                </div>
                <div class="form-control mt-6">
                    <button type="submit" name="submit" class="btn btn-primary bg-blue-500 text-white">Update</button>
                </div>
            </form>
        </div>
    </main>
</body>

<script>
document.getElementById('navTitle').innerText = "Update Password";
</script>

</html>
