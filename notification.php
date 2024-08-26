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

$m= "";
$onesignalappid = "";
$onesignalrestkey = "";

// Fetch OneSignal credentials from the database
$sql = "SELECT one_app_id, one_api_key FROM settings WHERE id=1";
$res = $conn->query($sql);




if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $onesignalappid = $row['one_app_id'];
    $onesignalrestkey = $row['one_api_key'];
} else {
    echo "Error: OneSignal credentials not found.";
    exit();
}

// OneSignal notification sending logic
if(isset($_POST['submit'])) {

    $content = array(
        "en" => $_POST['one_msg']
    );
    $headings = array(
        "en" => $_POST['one_title']
    );

    $fields = array(
        'app_id' => $onesignalappid,
        'headings' => $headings,
        'included_segments' => array('All'),
        'data' => array("foo" => "bar"),
        'large_icon' => "ic_launcher_round.png",
        'contents' => $content
    );

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                               'Authorization: Basic ' . $onesignalrestkey));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    if(empty($onesignalrestkey) OR empty($onesignalappid)){
        $m = "Failed to send message";
    } else {
       $m = "Successfully to send message";
    }

}
?>



<!DOCTYPE html>
<html data-theme="light" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notifications</title>

    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css"
      rel="stylesheet"
      type="text/css"
    />
  </head>

  <body class="bg-[#F1F4F8] min-h-screen text-black container mx-auto">
    <main
      class="bg-white mx-auto w-full m-3 mt-8 xs:w-[70%] max-w-[70%] shadow-lg p-6 border-t-4 border-blue-800 rounded-lg"
    >
      <h4 class="text-xl font-semibold mb-6">Notification</h4>

      <p class="text-lg font-bold text-red-500 text-center mt-8"><?php if ($m != '') echo $m; ?></p>
          

      <form
        data-submit="true"
        id="form"
        action=""
        autocomplete="off"
        method="POST"
      >
        <div class="form-group mb-4">
          <label for="one_title" class="block text-sm font-medium text-gray-700"
            >Title</label
          >
          <input
            type="text"
            id="one_title"
            name="one_title"
            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            required
          />
        </div>

        <div class="form-group mb-4">
          <label for="one_msg" class="block text-sm font-medium text-gray-700"
            >Message</label
          >
          <textarea
            id="one_msg"
            name="one_msg"
            rows="4"
            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            required
          ></textarea>
        </div>

        <div class="form-group mb-4">
          <label for="url" class="block text-sm font-medium text-gray-700"
            >Launch URL</label
          >
          <input
            type="text"
            id="url"
            name="url"
            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
          />
        </div>

        <button
          id="btn-form-submit"
          name="submit"
          value="1"
          type="submit"
          class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
          Send Notification
        </button>
      </form>
    </main>

    <script>
      document.getElementById("navTitle").innerText = "Notification";
    </script>
  </body>
</html>
