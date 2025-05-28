<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $adn = "DELETE FROM rpos_products WHERE prod_id = ?";
    $stmt = $mysqli->prepare($adn);

    if ($stmt) {
        $stmt->bind_param('s', $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $success = "Product Deleted Successfully!" && header("refresh:1; url=products.php");
        } else {
            $err = "Deletion failed. Product not found.";
        }

        $stmt->close();
    } else {
        $err = "Query preparation failed.";
    }
}

require_once('partials/_head.php');
?>

<body>
<style>
    body {
        background-color: #b09081;
        font-family: "DynaPuff", system-ui;
    }
    .card {
        background-color: #F7E6CA !important;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        padding: 15px;
    }
    .card-header, .card-footer {
        background-color: #F7E6CA !important;
    }
    .fixed-square {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }
    form.form-inline {
        margin-bottom: 15px;
    }
</style>

<?php require_once('partials/_sidebar.php'); ?>

<div class="main-content">
    <?php require_once('partials/_topnav.php'); ?>

    <div style="background-image: url(assets/img/theme/bjes.png); background-size: cover;" class="header pb-8 pt-5 pt-md-9">
        <span class="mask bg-gradient-dark opacity-5"></span>
        <div class="container-fluid">
            <div class="header-body"></div>
        </div>
    </div>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">

    <div class="container-fluid mt--8">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0" style="background-color: #F7E6CA;">
                        <a href="add_product.php" class="btn btn-outline-success">
                            <i class="fas fa-utensils"></i> Add New Product
                        </a>

                        <!-- Search form -->
                        <form method="GET" class="form-inline float-right">
                            <input 
                                type="text" 
                                name="search" 
                                class="form-control mr-2" 
                                placeholder="Search by name or barcode" 
                                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                            >
                            <button type="submit" class="btn btn-outline-primary">Search</button>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" style="background-color: #F7E6CA;">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Image</th>
                                    <th scope="col">Barcode</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Pagination variables
                                $limit = 10;
                                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                if ($page < 1) $page = 1;
                                $start = ($page - 1) * $limit;

                                // Search term
                                $search = isset($_GET['search']) ? trim($_GET['search']) : '';
                                $search_param = "%" . $search . "%";

                                // Prepare count query
                                if (!empty($search)) {
                                    $count_query = "SELECT COUNT(*) AS total FROM rpos_products WHERE prod_name LIKE ? OR barcode LIKE ?";
                                    $count_stmt = $mysqli->prepare($count_query);
                                    $count_stmt->bind_param("ss", $search_param, $search_param);
                                } else {
                                    $count_query = "SELECT COUNT(*) AS total FROM rpos_products";
                                    $count_stmt = $mysqli->prepare($count_query);
                                }

                                $count_stmt->execute();
                                $count_result = $count_stmt->get_result();
                                $total = $count_result->fetch_object()->total;
                                $pages = ceil($total / $limit);
                                $count_stmt->close();

                                // Data fetch query (DESCENDING ORDER)
                                if (!empty($search)) {
                                    $ret = "SELECT * FROM rpos_products WHERE prod_name LIKE ? OR barcode LIKE ? ORDER BY prod_id DESC LIMIT ?, ?";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->bind_param("ssii", $search_param, $search_param, $start, $limit);
                                } else {
                                    $ret = "SELECT * FROM rpos_products ORDER BY prod_id DESC LIMIT ?, ?";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->bind_param("ii", $start, $limit);
                                }

                                $stmt->execute();
                                $res = $stmt->get_result();

                                if ($res->num_rows == 0) {
                                    echo '<tr><td colspan="5" class="text-center">No products found.</td></tr>';
                                } else {
                                    while ($prod = $res->fetch_object()) {
                                        ?>
                                        <tr>
                                            <td>
                                                <img src="assets/img/products/<?php echo $prod->prod_img ?: 'default.jpg'; ?>" class="img-thumbnail fixed-square" alt="<?php echo htmlspecialchars($prod->prod_name); ?>">
                                            </td>
                                            <td><?php echo htmlspecialchars($prod->barcode); ?></td>
                                            <td><?php echo htmlspecialchars($prod->prod_name); ?></td>
                                            <td>P <?php echo number_format($prod->prod_price, 2); ?></td>
                                            <td>
                                                <a href="products.php?delete=<?php echo $prod->prod_id; ?>" onclick="return confirm('Are you sure you want to delete this product?');">
                                                    <button class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </a>
                                                <a href="update_product.php?update=<?php echo $prod->prod_id; ?>">
                                                    <button class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i> Update
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                $stmt->close();
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <?php
                                $base_url = "products.php?";
                                if (!empty($search)) {
                                    $base_url .= "search=" . urlencode($search) . "&";
                                }

                                for ($i = 1; $i <= $pages; $i++): ?>
                                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                        <a class="page-link" href="<?php echo $base_url . "page=$i"; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once('partials/_footer.php'); ?>
    </div>
</div>

<?php require_once('partials/_scripts.php'); ?>
</body>
</html>
