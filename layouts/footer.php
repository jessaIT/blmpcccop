</div>
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- accounts -->

<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Admin</h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row col-xl-6 col-md-12 mb-2 align-items-start">
                    <div class="col-1">
                        <a class="btn btn-success btn" data-toggle="modal" title="Add new Administrator (Single Insertion)" data-target="#newModal2"><i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>

                <div class="table-responsive">
                    <?php
                    include('functions/connection.php');
                    $sql = "SELECT * FROM members_tbl order by lastname ASC";
                    $result = $conn->query($sql);
                    $conn->close();
                    ?>

                    <p class="text-success h4">Admin Accounts</p>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">Member ID</th>
                                <th class="text-center ">Name <span class="small">(lastname, firstname middlename)</span></th>
                                <th class="text-center">Mobile Number</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Operation</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                                <tr>
                                    <td class="text-center"><b class="text-success"><?= $row['mem_id'] ?></b></td>
                                    <td class="text-center"><?= $row['lastname'] ?>, <?= $row['firstname'] ?> <?= $row['middlename'] ?></td>
                                    <td class="text-center"><?= $row['mobile_number'] ?></td>
                                    <td class="text-center"><?= $row['status'] ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#updateModal<?= $row['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>

                                        <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal"><i class="fa-solid fa-trash"></i></a>

                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#viewModal<?= $row['id'] ?>"><i class="fa-solid fa-eye"></i></button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newMember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add member</h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form class="user" method="post" action="./functions/add_member.php" enctype="multipart/form-data">
                    <!-- <div class="row">
                                                                    <div class="col-6 mx-auto">
                                                                        <div class="input-group mb-3">
                                                                            <input type="file" class="form-control" id="image" name="image" class="image">


                                                                        </div>
                                                                        <div id="imagePreview" class="col-md-12 col-12 mx-auto  ">
                                                                            <img src="img/undraw_profile_2.svg" width="200" alt="Image Preview">
                                                                        </div>
                                                                    </div>
                                                                </div> -->

                    <div class="row py-4">
                        <div class="col-lg-6 mx-auto">

                            <!-- Upload image input-->
                            <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                <input id="upload" name="image" type="file" onchange="readURL(this);" class="form-control border-0">
                                <label id="upload-label" for="upload" class="font-weight-light text-muted">Choose file</label>
                                <div class="input-group-append">
                                    <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Choose file</small></label>
                                </div>
                            </div>

                            <!-- Uploaded image area-->
                            <p class="font-italic text-dark text-center">The image uploaded will be rendered inside the box below.</p>
                            <div class="image-area mt-4"><img id="imageResult" src="#" alt="" class="img-fluid rounded shadow-sm mx-auto d-block"></div>

                        </div>
                    </div>

                    <script>
                        function readURL(input) {
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();

                                reader.onload = function(e) {
                                    $('#imageResult')
                                        .attr('src', e.target.result);
                                };
                                reader.readAsDataURL(input.files[0]);
                            }
                        }

                        $(function() {
                            $('#upload').on('change', function() {
                                readURL(input);
                            });
                        });
                        var input = document.getElementById('upload');
                        var infoArea = document.getElementById('upload-label');

                        input.addEventListener('change', showFileName);

                        function showFileName(event) {
                            var input = event.srcElement;
                            var fileName = input.files[0].name;
                            infoArea.textContent = 'File name: ' + fileName;
                        }
                    </script>

                    <div class="row col-12 mx-auto">
                        <div class="col-4">
                            <p class="text-success small h5">Name</p>
                            <div class="form-group">
                                <label for="firstname">Firstname</label>
                                <input type="text" class="form-control form-control" id="firstname" name="firstname" placeholder="Juan" required>
                            </div>
                            <div class="form-group">
                                <label for="middlename">Middle Name</label>
                                <input type="text" class="form-control form-control" name="middlename" placeholder="Mendez" required>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Lastname</label>
                                <input type="text" class="form-control form-control" id="lastname" name="lastname" placeholder="Dela Cruz" required>
                            </div>
                            <div class="form-group">
                                <label for="extension">Suffix</label>
                                <select class="form-control form-select form-select-sm" name="extension">
                                    <option value="N/A">None</option>
                                    <option value="Sr.">Sr</option>
                                    <option value="Jr.">JR</option>
                                    <option value="I">I</option>
                                    <option value="I">II</option>
                                    <option value="I">III</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-4">
                            <p class="text-success small h5">Basic Information</p>
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" class="form-control form-control" id="dob" name="dob" required>
                            </div>
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="number" class="form-control form-control" name="age" required>
                            </div>
                            <div class="form-group">
                                <label for="pob">Place of Birth</label>

                                <textarea name="pob" id="pob" cols="10" rows="4" class="form-control" placeholder="Place of Birth" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="civil-status">Civil Status</label>
                                <select class="form-control form-select form-select-sm" name="civil-status">
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Divorced">Divorced</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tin">TIN</label>
                                <input type="text" class="form-control form-control" id="tin" name="tin" aria-describedby="emailHelp" placeholder="TIN number" required>
                            </div>
                        </div>

                        <div class="col-4">
                            <p class="text-success small h5 mb-6">Contact Information</p>
                            <div class="form-group">
                                <label for="mobile-number">Mobile Number</label>
                                <input type="text" class="form-control form-control" id="mobile-number" name="mobile-number" placeholder="Mobile" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control form-control" name="email" placeholder="Email Address" required>
                            </div>


                            <p class="text-success small h5 mt-3">Address</p>
                            <div class="form-group">
                                <label for="zone">Zone</label>
                                <input type="text" class="form-control form-control" id="zone" name="zone" placeholder="Zone (Purok)" required>
                            </div>
                            <div class="form-group">
                                <label for="brgy">Barangay</label>
                                <input type="text" class="form-control form-control" name="brgy" placeholder="Barangay" required>
                            </div>
                            <div class="form-group">
                                <label for="municipality">Municipality</label>
                                <input type="text" class="form-control form-control" name="municipality" placeholder="Municipality" required>
                            </div>
                            <div class="form-group">
                                <label for="province">Province</label>
                                <input type="text" class="form-control form-control" name="province" placeholder="Province" required>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.getElementById('image').addEventListener('change', function(e) {
                            const imagePreview = document.getElementById('imagePreview');
                            const file = e.target.files[0];
                            const reader = new FileReader();

                            reader.onload = function() {
                                imagePreview.innerHTML = `<img src="${reader.result}" width="100" alt="Image Preview">`;
                            };

                            if (file) {
                                reader.readAsDataURL(file);
                            }
                        });
                    </script>

            </div>

            <div class="modal-footer">
                <button class="btn btn-danger btn-sm" type="button" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-sm btn-success">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="newModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Admin</h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form class="user" method="post" action="./functions/add_member.php" enctype="multipart/form-data">


                    <div class="row col-12 mx-auto">
                        <div class="col-12">
                            <p class="text-success small h5">Email Address</p>
                            <div class="form-group">
                                <label for="email_address">Firstname</label>
                                <input type="email" class="form-control form-control" id="email" name="email_address" placeholder="jdl@gmail.com" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control form-control" name="username" placeholder="jdl_cruz" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="extension">Suffix</label>
                                <select class="form-control form-select form-select-sm" name="extension">
                                    <option value="N/A">None</option>
                                    <option value="Sr.">Sr</option>
                                    <option value="Jr.">JR</option>
                                    <option value="I">I</option>
                                    <option value="I">II</option>
                                    <option value="I">III</option>
                                </select>
                            </div>

                        </div>


                    </div>
                    <script>
                        document.getElementById('image').addEventListener('change', function(e) {
                            const imagePreview = document.getElementById('imagePreview');
                            const file = e.target.files[0];
                            const reader = new FileReader();

                            reader.onload = function() {
                                imagePreview.innerHTML = `<img src="${reader.result}" width="100" alt="Image Preview">`;
                            };

                            if (file) {
                                reader.readAsDataURL(file);
                            }
                        });
                    </script>

            </div>

            <div class="modal-footer">
                <button class="btn btn-danger btn-sm" type="button" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-sm btn-success">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to logout?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger btn-sm" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-success btn-sm" href="./functions/logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>


<!-- modals -->

<div class="modal fade" id="viewModalAdmin<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View member</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="member_id" value="<?php echo $row["id"]; ?>">
                <div class="row col-12 mx-auto">
                    <div class="col-4">
                        <p class="text-success h5">Personal Details</p>
                        <div class="form-group">
                            <label for="firstname">Firstname</label>
                            <input type="text" readonly class="form-control form-control" id="firstname" value="<?= $row['firstname'] ?>" name="firstname" placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <label for="middlename">Middle Name</label>
                            <input type="text" readonly class="form-control form-control" name="middlename" value="<?= $row['middlename'] ?>" placeholder="Middle Name">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Lastname</label>
                            <input type="text" readonly class="form-control form-control" id="lastname" value="<?= $row['lastname'] ?>" name="lastname" placeholder="Last Name">
                        </div>
                        <div class="form-group">
                            <label for="extension">Extension</label>
                            <input type="text" readonly class="form-control form-control" id="extension" name="extension" aria-describedby="emailHelp" value="<?= $row['extension'] ?>" placeholder="Extension (ex. Jr.)">
                        </div>


                    </div>

                    <div class="col-4 mt-4">
                        <p class="text-success h5">Basic Information</p>
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="text" readonly class="form-control form-control" id="dob" value="<?= $row['dob'] ?>" name="dob">
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="number" readonly class="form-control form-control" name="age" value="<?= $row['age'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="pob">Place of Birth</label>
                            <input type="text" readonly class="form-control form-control" id="pob" value="<?= $row['pob'] ?>" name="pob" placeholder="Place of Birth">
                        </div>
                        <div class="form-group">
                            <label for="civil-status">Civil Status</label>
                            <input type="text" readonly class="form-control form-control" id="civil-status" name="civil-status" aria-describedby="emailHelp" value="<?= $row['civil_status'] ?>" placeholder="Civil Status">
                        </div>

                        <div class="form-group">
                            <label for="tin">TIN</label>
                            <input type="text" readonly class="form-control form-control" id="tin" name="tin" aria-describedby="emailHelp" value="<?= $row['tin'] ?>" placeholder="TIN number">
                        </div>
                    </div>

                    <div class="col-4 mt-4">
                        <p class="text-success h5 mb-6">Contact Information</p>
                        <div class="form-group">
                            <label for="mobile-number">Mobile Number</label>
                            <input type="text" readonly class="form-control form-control" id="mobile-number" value="<?= $row['mobile_number'] ?>" name="mobile-number" placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" readonly class="form-control form-control" name="email" value="<?= $row['email'] ?>" placeholder="Email Address">
                        </div>


                        <p class="text-success h5 mt-3">Address</p>

                        <div class="form-group">
                            <label for="brgy">Barangay</label>
                            <input type="text" readonly class="form-control form-control" name="brgy" value="<?= $row['brgy'] ?>" placeholder="Barangay">
                        </div>
                        <div class="form-group">
                            <label for="municipality">Municipality</label>
                            <input type="text" readonly class="form-control form-control" name="municipality" value="<?= $row['municipality'] ?>" placeholder="Municipality">
                        </div>
                        <div class="form-group">
                            <label for="province">Province</label>
                            <input type="text" readonly class="form-control form-control" name="province" value="<?= $row['province'] ?>" placeholder="Province">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end of modals -->

<!-- update profile -->
<div class="modal fade" id="updateProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="./functions/update_profile.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>

                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password">
                    </div>

                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password">
                    </div>

                    <button class="btn btn-danger btn-sm" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success btn-sm" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>



<script src="./vendor/jquery/jquery.min.js"></script>
<script src="./vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="./js/sb-admin-2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>