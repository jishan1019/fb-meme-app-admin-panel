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

if (isset($_POST['submit'])) {
  $ban_ad_id = mysqli_real_escape_string($conn, $_POST['ban_ad_id']);
  $int_ad_id = mysqli_real_escape_string($conn, $_POST['int_ad_id']);
  $is_ads_enable = mysqli_real_escape_string($conn, $_POST['is_ads_enable']);
  $package_name = mysqli_real_escape_string($conn, $_POST['package_name']);
  $one_app_id = mysqli_real_escape_string($conn, $_POST['one_app_id']);
  $one_api_key = mysqli_real_escape_string($conn, $_POST['one_api_key']);
  $notice = mysqli_real_escape_string($conn, $_POST['notice']);

  $sq = "UPDATE settings SET ban_ad_id='$ban_ad_id', int_ad_id='$int_ad_id', is_ads_enable='$is_ads_enable',
   package_name='$package_name', one_app_id='$one_app_id', one_api_key='$one_api_key', notice='$notice' WHERE id=1";

  $conn->query($sq);
}

$sql = "SELECT * FROM settings WHERE id=1";
$res = $conn->query($sql);
$row = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html data-theme="light" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Settings</title>

    <!-- Css -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="bg-[#F1F4F8] min-h-screen text-black container mx-auto">
    <main class="bg-white mx-auto w-full m-3 mt-8 xs:w-[70%] max-w-[70%] shadow p-5 border-t-2 border-blue-800">
        <form method="POST">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Settings</h1>
            </div>

            <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-black">Banner Ads Id</span>
                    </label>
                    <input name="ban_ad_id" type="text" value="<?php echo $row['ban_ad_id']; ?>"
                        class="input input-bordered bg-transparent border-2 border-black text-black" required />
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-black">Interstitial Ads Id</span>
                    </label>
                    <input name="int_ad_id" type="text" value="<?php echo $row['int_ad_id']; ?>"
                        class="input input-bordered bg-transparent border-2 border-black text-black" required />
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-black">Ads Enable</span>
                    </label>
                    <select name="is_ads_enable" class="input input-bordered bg-transparent border-2 border-black text-black" required>
                        <option value="1" <?php echo $row['is_ads_enable'] == 1 ? 'selected' : ''; ?>>Yes</option>
                        <option value="0" <?php echo $row['is_ads_enable'] == 0 ? 'selected' : ''; ?>>No</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-black">Package name</span>
                    </label>
                    <input name="package_name" type="text" value="<?php echo $row['package_name']; ?>"
                        class="input input-bordered bg-transparent border-2 border-black text-black" required />
                </div>


                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-black">Onesignal App id</span>
                    </label>
                    <input name="one_app_id" type="text" value="<?php echo $row['one_app_id']; ?>"
                        class="input input-bordered bg-transparent border-2 border-black text-black" required />
                </div>


                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-black">Onesignal Api key</span>
                    </label>
                    <input name="one_api_key" type="text" value="<?php echo $row['one_api_key']; ?>"
                        class="input input-bordered bg-transparent border-2 border-black text-black" required />
                </div>





                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-black">Notice</span>
                    </label>
                    <textarea class="textarea textarea-secondary bg-transparent" placeholder="notice" rows="1"
                        name="notice"><?php echo $row['notice']; ?></textarea>
                </div>

                <div class="form-control mt-6">
                    <button type="submit" name="submit" class="bg-blue-800 py-2 shadow rounded text-white">
                        Save
                    </button>
                </div>
            </section>
        </form>
    </main>
</body>

<script>
document.getElementById('navTitle').innerText = "Settings";
</script>


</html>