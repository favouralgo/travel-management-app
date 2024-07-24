<?php require "../layout/header.php"; ?>      
<?php require "../../config/connection.php"; ?>  

<?php

if (!isset($_SESSION["adminname"])) {
    header("location: ".ADMINURL."");
}

// Query for admins
$adminsQuery = "SELECT * FROM admins";
$adminsResult = $connection->query($adminsQuery);

?>

<div class="row-2">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4 d-inline">Admins</h5>
             <a  href="<?php echo ADMINURL; ?>/admins/create-admins.php" class="btn btn-primary mb-4 text-center float-right">Create Admins</a>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Admin ID</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($admin = $adminsResult->fetch_assoc()) : ?>
                        <tr>
                            <th scope="row"><?php echo $admin["id"]; ?></th>
                            <td><?php echo $admin["adminname"]; ?></td>
                            <td><?php echo $admin["email"]; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</div>

<?php require "../layout/footer.php"; ?>  
