<?php include('layouts/headers.php') ?>
<?php include('layouts/sidebar.php') ?>

<div id="content-wrapper" class="d-flex flex-column" >
    <div id="content bg-dark">
        <?php include('layouts/topbar.php') ?>

        <?php

        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: login.php");
            exit;
        }

        $username = $_SESSION["username"];
        ?>

        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-space-between mb-4">

            </div>

            <script>
                function displaySuccessMessage(message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: message,
                        confirmButtonText: 'OK'
                    });
                }
            </script>

            <div class="row col-xl-6 col-md-12 mb-2">
                <button class="btn mr-2 bg-success text-white border-0 shadow-0"><a href="add-member.php" class="text-white"><i class="fa-solid fa-plus"></i></a></button>

                <button class="btn mr-2 bg-warning text-white border-0 shadow-0" data-toggle="modal" data-target="#importModal"><i class="fa-solid fa-file-import"></i></button>

                <button class="btn bg-primary text-white border-0 shadow-0">
                    <a href="./functions/export_members.php?type=excel" class="text-white"><i class="fa-solid fa-cloud-arrow-down"></i></a>
                </button>
            </div>

            <?php
            if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
                $successMessage = $_SESSION['success'];
                unset($_SESSION['success']);
                echo '<script>displaySuccessMessage("' . $successMessage . '");</script>';
            }
            ?>

            <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title small" id="importModalLabel">Import(.csv)</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="./functions/import_members.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="csv_file">Choose CSV File:</label>
                                    <input type="file" name="csv_file" class="form-control-file" accept=".csv" required>
                                </div>
                                <button type="submit" class="btn btn-success">Import Members</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-md-12 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="table-responsive">



                                <?php
                                include('functions/connection.php');
                                $sql = "SELECT * FROM members_tbl order by lastname ASC";
                                $result = $conn->query($sql);
                                $conn->close();
                                ?>

                                <p class="text-success h4">MEMBERS LIST</p>
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID #</th>
                                            <th class="text-center ">Name <span class="small">(lastname, firstname middlename)</span></th>
                                            <th class="text-center">Mobile Number</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Operation</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()) : ?>
                                            <tr>
                                                <td class="text-center"><b class="text-success"><?= $row['id'] ?></b></td>
                                                <td class="text-center"><?= $row['lastname'] ?>, <?= $row['firstname'] ?> <?= $row['middlename'] ?></td>
                                                <td class="text-center"><?= $row['mobile_number'] ?></td>
                                                <td class="text-center"><?= $row['status'] ?></td>
                                                <td class="text-center">
                                                    <a class="btn btn-success btn-sm" href="update-member.php?id=<?php echo $row["id"]; ?>"><i class="fa-solid fa-pen-to-square"></i></a>

                                                    <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal"><i class="fa-solid fa-trash"></i></a>

                                                    <a class="btn btn-warning btn-sm" href="view-member.php?id=<?php echo $row["id"]; ?>"><i class="fa-solid fa-eye"></i></a>
                                                </td>
                                            </tr>



                                            <!-- Delete Member Modal-->
                                            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete this member?</h5>

                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <p>Deleting a member also remove it's data from database. Are you sure you want to continue?</p>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button class="btn btn-warning btn-sm" type="button" data-dismiss="modal">Cancel</button>
                                                            <a class="btn btn-danger btn-sm" href="./functions/delete_member.php?id=<?php echo $row["id"]; ?>">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    function displaySuccessModal(message) {
        var modal = document.createElement("div");
        modal.className = "modal";
        var modalContent = document.createElement("div");
        modalContent.className = "modal-content";
        var closeButton = document.createElement("span");
        closeButton.className = "close";
        closeButton.innerHTML = "&times;";
        closeButton.onclick = function() {
            modal.style.display = "none";
        };
        modalContent.appendChild(closeButton);
        modalContent.innerHTML += "<p>" + message + "</p>";
        modal.appendChild(modalContent);
        document.body.appendChild(modal);
        modal.style.display = "block";
    }
    if (typeof successMessage !== "undefined" && successMessage !== "") {
        displaySuccessModal(successMessage);
    }
</script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
<?php include('layouts/footer.php'); ?>