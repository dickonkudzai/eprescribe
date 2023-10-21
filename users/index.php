<?php
    include "../includes/header.php";
    include "../includes/sidebar.php";
    include "../config/utilities.php";
    require_once '..\config\Config.php';
    use \config\Config;
    $config = new Config();
    $postData = $_POST;
    $getData = $_GET;
    $dbConnect = $config->databaseConnection();
?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Users</h1>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Users
            </div>
            <div class="card-body">
                <table id="users">
                    <thead>
                    <tr>
                        <th><?echo $_SESSION['username']?></th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Mobile Number</th>
                        <th>National ID</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Mobile Number</th>
                        <th>National ID</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                        <?php echo getUsers($dbConnect)?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?php
include "../includes/footer.php";
?>
<script src="user.js"></script>
