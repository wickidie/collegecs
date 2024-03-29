<?php
  include_once 'db-connect.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codelab PHP1</title>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>

<!-- Sidebar -->
<div class="w3-sidebar w3-bar-block" style="display:none;z-index:5" id="mySidebar">
  <button class="w3-bar-item w3-button w3-xxlarge" onclick="w3_close()">Close &times;</button>
  <a href="users-register.php" class="w3-bar-item w3-button">Register</a>
  <a href="session-destroy.php" class="w3-bar-item w3-button">Logout
  </a>
</div>

<!-- Page Content -->
<div class="w3-overlay" onclick="w3_close()" style="cursor:pointer" id="myOverlay"></div>

<div>
  <button class="w3-button w3-white w3-xxlarge" onclick="w3_open()">&#9776;</button>
</div>

<div class="w3-container">
  <h2>Tabel Users</h2>
  <form method="GET">
    <input type="text" placeholder="Search.." name="search">
      <a href="">
        <button type='submit'>Submit</button>
      </a>
  </form>

  <table class="w3-table-all w3-centered">
    <thead>
      <tr class="w3-red">
        <th>No</th>
        <th>Avatar</th>
        <th>Userid</th>
        <th>Passcode</th>
        <th>Action</th>
      </tr>
    </thead>
    <?php
      $item_per_page = 2;
      $search_value = $_GET['search'];
      $sql = "SELECT `userid`, `passcode`, `avatar` FROM `users` WHERE 1";
      $search_result = mysqli_query($conn, $sql);
      $search_result_row = mysqli_num_rows($search_result);

      $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
      $offset = ($current_page - 1) * $item_per_page;

      if (isset($_GET['search'])) {
        if (!empty($_GET['search'])) {
          $sql = "SELECT * FROM `users` where userid like '%$search_value%' LIMIT $offset, $item_per_page";
          $search_result = mysqli_query($conn, $sql);
          $sql = "SELECT * FROM `users` where userid like '%$search_value%'";
          $search_result_total = mysqli_query($conn, $sql);
          $search_result_row = mysqli_num_rows($search_result_total);
        }else{
          echo "Empty ";
          $sql = "SELECT `userid`, `passcode`, `avatar` FROM `users` WHERE 1 LIMIT $offset, $item_per_page";
          $search_result = mysqli_query($conn, $sql);
        }
      }
      $total_page = ceil($search_result_row / $item_per_page);
      echo "Search for : $search_value <br>";
      echo "Showing : $total_page pages <br>";
      echo "With total : $search_result_row result<br>";
      $i = 0;
      if ($search_result_row > 0) {
        while ($row = mysqli_fetch_assoc($search_result)) {
          $i++;
          echo "<tr>" .
                "<td>" . $i . " " .  "</td>" .
                "<td>" . "<img src='https://www.w3schools.com/w3css/" . $row['avatar'] . "'style='width:50px'></td>" .  "</td>" .
                "<td>" . $row['userid'] . " " . "</td>" .
                "<td>" . $row['passcode'] . " " . "</td>" .
                "<td>" .
                  "<a href='users-update-form.php?userid=" . $row['userid'] . "'><span class='material-symbols-outlined'>build</span></a>" .
                  "<a href='users-delete.php?userid=" . $row['userid'] . "'><span class='material-symbols-outlined'>delete</span></a>" .
                  "<a href='users-detail.php?userid=" . $row['userid'] . "'><span class='material-symbols-outlined'>info</span></a>" .
                "</td>" .
              "</tr>";
        }
        echo "<div class='w3-center'>";
        echo "<div class='w3-bar w3-border w3-round'>";
        echo "<a href='users-list.php?search=$search_value&page=1' class='w3-bar-item w3-button'>&laquo First</a>";
        for ($i=1; $i < $total_page + 1; $i++) { 
          echo "<a href='users-list.php?search=$search_value&page=$i' class='w3-bar-item w3-button'>$i</a>";
        }
        echo "<a href='users-list.php?search=$search_value&page=$total_page' class='w3-bar-item w3-button'>Last &raquo</a>";
        echo "</div>";
        echo "</div>";
      }

      mysqli_close($conn);
    ?>
  </table>
</div>
<!-- JS to open and close sidebar with overlay effect -->
<script>
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}

function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}
</script>
          
</body>