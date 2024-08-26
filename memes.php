<?php
session_start();
include "header.php";
include "auth/connect.php";

$userEmail = $_SESSION['userEmail'];

$conn = connect();
$imageBaseUrl = getImgUrl();

$m = "";

if (empty($userEmail)) {
    header('location: login.php');
    exit();
}

$items_per_page = 15; // Items per page



$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $items_per_page;

// Date filter
$start_date = isset($_POST['start_date']) ? mysqli_real_escape_string($conn, $_POST['start_date']) : '';
$end_date = isset($_POST['end_date']) ? mysqli_real_escape_string($conn, $_POST['end_date']) : '';

$date_filter_sql = "";
if ($start_date && $end_date) {
    $date_filter_sql = "WHERE create_at BETWEEN '$start_date' AND '$end_date'";
}

// Add Meme
if (isset($_POST['submit'])) {
    $memeImgLink = mysqli_real_escape_string($conn, $_POST['memeImgLink']);

    $sql = "INSERT INTO memes(img, `like`, download, create_at) VALUES ('$memeImgLink', '0', '0', current_timestamp())";
    if ($conn->query($sql) === true) {
        $m = "Meme Added";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Pagination
$sql = "SELECT * FROM memes $date_filter_sql ORDER BY create_at DESC LIMIT $start_from, $items_per_page";
$res = $conn->query($sql);

// Get total number of memes for pagination
$total_sql = "SELECT COUNT(*) as total FROM memes $date_filter_sql";
$total_res = $conn->query($total_sql);
$total_row = $total_res->fetch_assoc();
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $items_per_page);
?>

<!DOCTYPE html>
<html data-theme="light" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Memes</title>

    <!-- Css -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white min-h-screen text-black container mx-auto">
    <main class="w-full md:w-[70%] shadow mx-auto mt-8 p-3 h-[75vh] overflow-auto border border-gray-100 ">
        <div class="mb-4">
            <!-- Date Filter Form -->
            <form method="POST" class="flex gap-4 mb-4">
                <input type="date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>" class="input input-bordered" />
                <input type="date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>" class="input input-bordered" />
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>
        
        <div class="overflow-auto">
            <table class="table">
                <!-- head -->
                <thead class="bg-blue-800">
                    <tr>
                        <th>#</th>
                        <th class="text-white">Img</th>
                        <th class="text-white">Like</th>
                        <th class="text-white">Download</th>
                        <th class="text-white">CreateAt</th>
                        <th class="text-white">Update</th>
                        <th class="text-white">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = $start_from + 1;
                    while ($row = $res->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th>" . $index . "</th>";
                        echo "<td><img src='" . $row['img'] . "' alt='image' width='50' height='50' /></td>";
                        echo "<td>" . $row['like'] . "</td>";
                        echo "<td>" . $row['download'] . "</td>";
                        echo "<td>" . date('F j, Y, h:i A', strtotime($row['create_at'])) . "</td>";
                        echo "<td>
                        <a href='#' onclick='showUpdateModal(" . $row['id'] . ", \"" . addslashes($row['img']) . "\", " . $row['like'] . ", " . $row['download'] . ")' class='text-white py-2 px-3 bg-green-400 rounded'>Update</a>
                        </td>";
                        echo "<td>
                        <a href='delete_memes.php?id=" . $row['id'] . "' class='text-white py-2 px-3 bg-red-500 rounded'>Delete</a>
                        </td>";
                        echo "</tr>";
                        $index++;
                    }
                    ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4 flex justify-between items-center">
                <div>
                    <span>Page <?php echo $page; ?> of <?php echo $total_pages; ?></span>
                </div>
                <div>
                    <?php if ($page > 1) { ?>
                        <a href="?page=<?php echo $page - 1; ?>" class="btn btn-secondary">Previous</a>
                    <?php } ?>
                    <?php if ($page < $total_pages) { ?>
                        <a href="?page=<?php echo $page + 1; ?>" class="btn btn-secondary">Next</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>

    <footer class="relative">
        <p class="h-[65px] w-16 bg-blue-800 text-white text-2xl cursor-pointer rounded-full flex items-center justify-center absolute right-8 bottom-0" onclick="my_modal_5.showModal()">
            <span>+</span>
        </p>

        <!-- Add Meme Modal -->
        <dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
            <div class="modal-box">
                <form method="POST" enctype="multipart/form-data">
                    <button id="closeModal" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    <h3 class="text-lg font-bold">Add Meme</h3>
                    <div class="form-control mt-4">
                        <input name="memeImgLink" type="text" placeholder="Enter Meme Img Link" class="input input-bordered bg-transparent border-1 border-black text-black" required />
                    </div>
                    <button name="submit" type="submit" class="btn mt-5">Add</button>
                </form>
            </div>
        </dialog>

        <!-- Update Meme Modal -->
        <dialog id="update_modal" class="modal modal-bottom sm:modal-middle">
            <div class="modal-box">
                <form id="update_form" method="POST">
                    <button id="closeUpdateModal" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    <h3 class="text-lg font-bold">Update Meme</h3>
                    <input type="hidden" name="meme_id" id="meme_id" />
                    <div class="form-control mt-4">
                        <label class="text-sm font-medium text-gray-700">Image Link</label>
                        <input name="memeImgLink" id="memeImgLink" type="text" class="input input-bordered bg-transparent border-1 border-black text-black" required />
                    </div>
                    <div class="form-control mt-4">
                        <label class="text-sm font-medium text-gray-700">Likes</label>
                        <input name="like" id="like" type="number" class="input input-bordered bg-transparent border-1 border-black text-black" required />
                    </div>
                    <div class="form-control mt-4">
                        <label class="text-sm font-medium text-gray-700">Downloads</label>
                        <input name="download" id="download" type="number" class="input input-bordered bg-transparent border-1 border-black text-black" required />
                    </div>
                    <button name="update" type="submit" class="btn mt-5">Update</button>
                </form>
            </div>
        </dialog>
    </footer>
</body>

<script>
const closeModalBtn = document.getElementById('closeModal');
const closeUpdateModalBtn = document.getElementById('closeUpdateModal');
document.getElementById('navTitle').innerText = "All Memes";

const modal = document.getElementById('my_modal_5');
const updateModal = document.getElementById('update_modal');

closeModalBtn.addEventListener('click', () => {
    modal.close();
});

closeUpdateModalBtn.addEventListener('click', () => {
    updateModal.close();
});

function showUpdateModal(id, img, like, download) {
    document.getElementById('meme_id').value = id;
    document.getElementById('memeImgLink').value = img;
    document.getElementById('like').value = like;
    document.getElementById('download').value = download;
    updateModal.showModal();
}

// Add form submission for update
document.getElementById('update_form').addEventListener('submit', function (event) {
    event.preventDefault();
   
    const formData = new FormData(this);
    fetch('update_memes.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        updateModal.close();
        location.reload(); // Reload the page to see updates
    });
});
</script>
</html>
