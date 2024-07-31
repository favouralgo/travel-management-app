<?php 
require "../layout/header.php"; 
require "../../config/connection.php";

// Ensure the session is started and the user is logged in
if (!isset($_SESSION["adminname"])) {
    header("location: ".ADMINURL."");
    exit();
}

// Get current admin's role
$currentAdminQuery = "SELECT role FROM admins WHERE adminname = ?";
$stmt = $connection->prepare($currentAdminQuery);
$stmt->bind_param("s", $_SESSION["adminname"]);
$stmt->execute();
$currentAdminResult = $stmt->get_result();
$currentAdmin = $currentAdminResult->fetch_assoc();
$stmt->close();

// Check if current admin is Super Admin
$isSuperAdmin = ($currentAdmin["role"] == 1);

// Query for admins 
$adminsQuery = "SELECT * FROM admins";
$adminsResult = $connection->query($adminsQuery);
?>

<div class="row-2">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4 d-inline">Admins</h5>

                <?php if ($isSuperAdmin): ?>
                    <!-- Display "Create Admins" button only for Super Admin -->
                    <a href="<?php echo ADMINURL; ?>admins/create-admins.php" class="btn btn-primary mb-4 text-center float-right">Create Admins</a>
                <?php endif; ?>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Admin ID</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <?php if ($isSuperAdmin): ?>
                                <th scope="col">Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($admin = $adminsResult->fetch_assoc()) : ?>
                        <tr>
                            <th scope="row"><?php echo htmlspecialchars($admin["id"]); ?></th>
                            <td><?php echo htmlspecialchars($admin["adminname"]); ?></td>
                            <td><?php echo htmlspecialchars($admin["email"]); ?></td>
                            <!-- Delete button -->
                            <?php if ($isSuperAdmin): ?>
                                <td>
                                    <button onclick="deleteAdmin(<?php echo htmlspecialchars($admin['id']); ?>)" class="btn btn-danger">Delete</button>
                                </td>
                            <?php endif; ?>
                                
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!--Sweet Alert JavaScript function-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function deleteAdmin(adminId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to delete this admin?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('delete-admin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'admin_id': adminId
                })
            }).then(response => response.json())
            .then(result => {
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: result.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.message,
                        confirmButtonText: 'OK'
                    });
                }
            }).catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while deleting the admin.',
                    confirmButtonText: 'OK'
                });
            });
        }
    });
}
</script>
<?php require "../layout/footer.php"; ?>
