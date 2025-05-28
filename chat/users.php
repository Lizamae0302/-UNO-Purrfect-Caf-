<?php
session_start();
include_once "php/config.php";
if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
}
?>
<?php include_once "header.php"; ?>

<body>
    <div class="wrapper">
        <section class="users">
            <header>
                <div class="content">
                    <?php
                    $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
                    if (mysqli_num_rows($sql) > 0) {
                        $row = mysqli_fetch_assoc($sql);
                    }
                    ?>
                    <img src="php/images/<?php echo $row['img']; ?>" alt="">
                    <div class="details">
                        <span><?php echo $row['fname'] . " " . $row['lname'] ?></span>
                        <?php 
                            // Set user status color
                            $statusColor = ($row['status'] == "Active now") ? "lime" : "crimson"; 
                        ?>
                        <p style="color: <?php echo $statusColor; ?>;">
                            <?php echo $row['status']; ?>
                        </p>
                    </div>
                </div>
                <div class="uwu" style='font-size:3rem;'>&#128490;</div>
                <div class="link"><a href="update.php">Edit Profile</a></div>
            </header>

            <div class="search">
        <span class="text"></span>
        <input type="text" placeholder=" Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
       
            <div class="users-list">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM users WHERE NOT unique_id = {$_SESSION['unique_id']}");

                while ($user = mysqli_fetch_assoc($query)) {
                    $statusColor = ($user['status'] == "Active now") ? "lime" : "crimson";
                ?>
                    <a href="chat.php?user_id=<?php echo $user['unique_id']; ?>">
                        <div class="content">
                            <img src="php/images/<?php echo $user['img']; ?>" alt="">
                            <div class="details">
                                <span><?php echo $user['fname'] . " " . $user['lname'] ?></span>
                                <p style="color: <?php echo $statusColor; ?>;">
                                    <?php echo $user['status']; ?>
                                </p>
                                <div class="status-dot <?php echo $statusClass; ?>"></div>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>

            <a href="logout.php" onclick="return confirm('Logout from delulu?');" class="logout">Logout</a>
        </section>
    </div>

    <script src="javascript/users.js"></script>
    
</body>
</html>
