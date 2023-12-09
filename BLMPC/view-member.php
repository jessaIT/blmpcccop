<?php include('layouts/headers.php') ?>
<?php include('layouts/sidebar.php') ?>
<?php include('functions/connection.php') ?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">
    <?php include('layouts/topbar.php') ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

<div class="row">
    <div class="col-xl-10 mx-auto col-md-12 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">

            

                <?php
                // Fetch the member details based on the provided ID
                
                $member_id = $_GET["id"];
                $sql = "SELECT * FROM members_tbl WHERE id=$member_id";
                $result = $conn->query($sql);
                $conn->close();

                $row = $result->fetch_assoc();

                ?>
                <p><a href="index.php"> <i class="fas fa-fw fa-arrow-left text-success"></i></a>MEMBER DETAILS</p>

                <input type="hidden" name="member_id" value="<?php echo $row["id"]; ?>">

                    
                    <div class="row col-10 mx-auto">
                        <div class="col-4">
                            <div class="col mb-3">
                                <img src="img/undraw_profile_2.svg" width="100" alt="">
                            </div>
                            <p class="text-success h5">Personal Details</p>
                            <div class="form-group">
                                <label for="firstname">Firstname</label>
                                <input type="text" readonly class="form-control form-control" id="firstname"
                                value="<?= $row['firstname'] ?>"
                                    name="firstname" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <label for="middlename">Middle Name</label>
                                <input type="text" readonly class="form-control form-control" name="middlename"
                                value="<?= $row['middlename'] ?>"
                                    placeholder="Middle Name">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Lastname</label>
                                <input type="text" readonly class="form-control form-control" id="lastname"
                                value="<?= $row['lastname'] ?>"
                                    name="lastname" placeholder="Last Name">
                            </div>
                            <div class="form-group">
                                <label for="extension">Extension</label>
                                <input type="text" readonly class="form-control form-control" id="extension"
                                    name="extension" aria-describedby="emailHelp"
                                    value="<?= $row['extension'] ?>"
                                    placeholder="Extension (ex. Jr.)">
                            </div>


                        </div>

                        <div class="col-4 mt-4">
                            <p class="text-success h5">Basic Information</p>
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="text" readonly class="form-control form-control" id="dob"
                                value="<?= $row['dob'] ?>"
                                    name="dob" >
                            </div>
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="number" readonly class="form-control form-control" name="age"
                                value="<?= $row['age'] ?>"
                                    >
                            </div>
                            <div class="form-group">
                                <label for="pob">Place of Birth</label>
                                <input type="text" readonly class="form-control form-control" id="pob"
                                value="<?= $row['pob'] ?>"
                                    name="pob" placeholder="Place of Birth">
                            </div>
                            <div class="form-group">
                                <label for="civil-status">Civil Status</label>
                                <input type="text" readonly class="form-control form-control" id="civil-status"
                                    name="civil-status" aria-describedby="emailHelp"
                                    value="<?= $row['civil_status'] ?>"
                                    placeholder="Civil Status">
                            </div>

                            <div class="form-group">
                                <label for="tin">TIN</label>
                                <input type="text" readonly class="form-control form-control" id="tin"
                                    name="tin" aria-describedby="emailHelp"
                                    value="<?= $row['tin'] ?>"
                                    placeholder="TIN number">
                            </div>
                        </div>

                        <div class="col-4 mt-4">
                            <p class="text-success h5 mb-6">Contact  Information</p>
                            <div class="form-group">
                                <label for="mobile-number">Mobile Number</label>
                                <input type="text" readonly class="form-control form-control" id="mobile-number"
                                value="<?= $row['mobile_number'] ?>"
                                    name="mobile-number" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" readonly class="form-control form-control" name="email"
                                value="<?= $row['email'] ?>"
                                    placeholder="Email Address">
                            </div>


                            <p class="text-success h5 mt-3">Address</p>
                            
                            <div class="form-group">
                                <label for="brgy">Barangay</label>
                                <input type="text" readonly class="form-control form-control" name="brgy"
                                value="<?= $row['brgy'] ?>"
                                    placeholder="Barangay">
                            </div>
                            <div class="form-group">
                                <label for="municipality">Municipality</label>
                                <input type="text" readonly class="form-control form-control" name="municipality"
                                value="<?= $row['municipality'] ?>"
                                    placeholder="Municipality">
                            </div>
                            <div class="form-group">
                                <label for="province">Province</label>
                                <input type="text" readonly class="form-control form-control" name="province"
                                value="<?= $row['province'] ?>"
                                    placeholder="Province">
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

</div>



</div>
    
</div>
</div>
    
<?php include('layouts/footer.php') ?>