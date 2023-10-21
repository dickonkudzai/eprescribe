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
                <div class="row">
                    <div class="col-6">
                        <i class="fas fa-table me-1"></i>
                        Users
                    </div>
                    <div class="col-6" align="right">
                        <button type="button" class="btn btn-sm btn-primary" id="add_user_button">Add User</button>
                    </div>
                </div>

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
                        <th style="text-align: center">Action</th>
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

<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModal">User</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <br>
            <form id="add_user_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_name">Surname</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Surname" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="gender">Gender</label>
                            <select  class="form-control" id="gender" name="gender">
                                <?php echo getGender()?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date_of_birth">Date of birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="email@email.com" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mobile_number">Mobile Number</label>
                            <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="0777777777" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="national_id">National ID</label>
                            <input type="text" class="form-control" id="national_id" name="national_id" placeholder="231563258C65" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="role_id">Role</label>
                            <select  class="form-control" id="role_id" name="role_id">
                                <?php echo getRoles($dbConnect)?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" id="submit" name="submit" value="Save">
                    <button class="btn btn-primary hidden" id="loader" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="action" id="action" value="">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>