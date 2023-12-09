<?php include('layouts/headers.php') ?>
<?php include('layouts/sidebar.php') ?>
<?php include('functions/connection.php') ?>
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php include('layouts/topbar.php') ?>
        <div class="container-fluid">



            <div class="row">
                <div class="col-xl-10 mx-auto col-md-12 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">

                            <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                                $member_id = $_POST['member_id'];
                                $firstname = $_POST['firstname'];
                                $middlename = $_POST['middlename'];
                                $lastname = $_POST['lastname'];
                                $extension = $_POST['extension'];
                                $dob = $_POST['dob'];
                                $age = $_POST['age'];
                                $pob = $_POST['pob'];
                                $civil_status = $_POST['civil-status'];
                                $tin = $_POST['tin'];
                                $mobile_number = $_POST['mobile-number'];
                                $email = $_POST['email'];
                                $brgy = $_POST['brgy'];
                                $municipality = $_POST['municipality'];
                                $province = $_POST['province'];
                                $region = $_POST['region'];

                                $sql = "UPDATE `members_tbl` SET `firstname`='$firstname',`middlename`='$middlename',`lastname`='$lastname',`extension`='$extension',`dob`='$dob',`age`='$age',`pob`='$pob',`civil_status`='$civil_status',`tin`='$tin',`mobile_number`='$mobile_number',`email`='$email',`brgy`='$brgy',`municipality`='$municipality',`province`='$province', `region`='$region' WHERE id = $member_id";


                                if ($conn->query($sql) === TRUE) {
                                    $_SESSION['success'] = "Member details have been updated!";
                                }


                                header("Location: index.php");
                                exit;
                            }
                            ?>

                            <?php

                            $member_id = $_GET["id"];
                            $sql = "SELECT * FROM members_tbl WHERE id=$member_id";
                            $result = $conn->query($sql);
                            $conn->close();

                            $row = $result->fetch_assoc();

                            ?>

                            <p><a href="index.php"> <i class="fas fa-fw fa-arrow-left text-success"></i></a>UPDATE MEMBER DETAILS</p>
                            <form class="user" action="" method="post">

                                <input type="hidden" name="member_id" value="<?php echo $row["id"]; ?>">
                                <div class="row col-10 mx-auto">
                                    <div class="col-4">
                                        <p class="text-success h5">Personal Details</p>
                                        <div class="form-group">
                                            <label for="firstname">Firstname</label>
                                            <input type="text" class="form-control form-control" id="firstname" value="<?= $row['firstname'] ?>" name="firstname" placeholder="First Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="middlename">Middle Name</label>
                                            <input type="text" class="form-control form-control" name="middlename" value="<?= $row['middlename'] ?>" placeholder="Middle Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="lastname">Lastname</label>
                                            <input type="text" class="form-control form-control" id="lastname" value="<?= $row['lastname'] ?>" name="lastname" placeholder="Last Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="extension">Suffix</label>
                                            <select class="form-control form-select form-select-sm" name="extension">
                                                <option value="<?php echo $row['extension'] ?>"><?php echo $row['extension'] ?></option>
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
                                        <p class="text-success h5">Basic Information</p>
                                        <div class="form-group">
                                            <label for="dob">Date of Birth</label>
                                            <input type="date" class="form-control form-control" id="dob" value="<?= $row['dob'] ?>" name="dob">
                                        </div>
                                        <div class="form-group">
                                            <label for="age">Age</label>
                                            <input type="number" class="form-control form-control" name="age" value="<?= $row['age'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="pob">Place of Birth</label>
                                            <input type="text" class="form-control form-control" id="pob" value="<?= $row['pob'] ?>" name="pob" placeholder="Place of Birth">
                                        </div>
                                        <div class="form-group">
                                            <label for="civil-status">Civil Status</label>
                                            <select class="form-control form-select form-select-sm" name="civil-status">
                                                <option value="<?php echo $row['civil_status'] ?>"><?php echo $row['civil_status'] ?></option>
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                                <option value="Widowed">Widowed</option>
                                                <option value="Divorced">Divorced</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="tin">TIN</label>
                                            <input type="text" class="form-control form-control" id="tin" name="tin" aria-describedby="emailHelp" value="<?= $row['tin'] ?>" placeholder="TIN number">
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <p class="text-success h5 mb-6">Contact Information</p>
                                        <div class="form-group">
                                            <label for="mobile-number">Mobile Number</label>
                                            <input type="text" class="form-control form-control" id="mobile-number" value="<?= $row['mobile_number'] ?>" name="mobile-number" placeholder="First Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" class="form-control form-control" name="email" value="<?= $row['email'] ?>" placeholder="Email Address">
                                        </div>


                                        <p class="text-success h5 mt-3">Address</p>

                                        <div class="form-group">
                                            <label for="brgy">Barangay</label>
                                            <input type="text" class="form-control form-control" name="brgy" value="<?= $row['brgy'] ?>" placeholder="Barangay">
                                        </div>
                                        <div class="form-group">
                                            <label for="municipality">Municipality</label>
                                            <input type="text" class="form-control form-control" name="municipality" value="<?= $row['municipality'] ?>" placeholder="Municipality">
                                        </div>
                                        <div class="form-group">
                                            <label for="province">Province</label>
                                            <input type="text" class="form-control form-control" name="province" value="<?= $row['province'] ?>" placeholder="Province">
                                        </div>

                                        <div class="form-group">
                                            <label for="province">Region</label>
                                            <select id="region" name="region" class="form-control">
                                                <option <?= $row['region'] == "NCR" ? 'selected' : ''  ?> value="NCR">National Capital Region (NCR)</option>
                                                <option <?= $row['region'] == "CAR" ? 'selected' : ''  ?> value="CAR">Cordillera Administrative Region (CAR)</option>
                                                <option <?= $row['region'] == "Region 1" ? 'selected' : ''  ?> value="Region 1">Ilocos Region (Region 1)</option>
                                                <option <?= $row['region'] == "Region 2" ? 'selected' : ''  ?> value="Region 2">Cagayan Valley (Region 2)</option>
                                                <!-- Continue adding options as needed -->
                                                <option <?= $row['region'] == "Region 3" ? 'selected' : ''  ?> value="Region 3">Central Luzon (Region 3)</option>
                                                <option <?= $row['region'] == "Region 4A" ? 'selected' : ''  ?> value="Region 4A">CALABARZON (Region 4A)</option>
                                                <option <?= $row['region'] == "Region 4B" ? 'selected' : ''  ?> value="Region 4B">MIMAROPA (Region 4B)</option>
                                                <option <?= $row['region'] == "Region 5" ? 'selected' : ''  ?> value="Region 5">Bicol Region (Region 5)</option>
                                                <option <?= $row['region'] == "Region 6" ? 'selected' : ''  ?> value="Region 6">Western Visayas (Region 6)</option>
                                                <option <?= $row['region'] == "Region 7" ? 'selected' : ''  ?> value="Region 7">Central Visayas (Region 7)</option>
                                                <option <?= $row['region'] == "Region 8" ? 'selected' : ''  ?> value="Region 8">Eastern Visayas (Region 8)</option>
                                                <option <?= $row['region'] == "Region 9" ? 'selected' : ''  ?> value="Region 9">Zamboanga Peninsula (Region 9)</option>
                                                <option <?= $row['region'] == "Region 10" ? 'selected' : ''  ?> value="Region 10">Northern Mindanao (Region 10)</option>
                                                <option <?= $row['region'] == "Region 11" ? 'selected' : ''  ?> value="Region 11">Davao Region (Region 11)</option>
                                                <option <?= $row['region'] == "Region 12" ? 'selected' : ''  ?> value="Region 12">SOCCSKSARGEN (Region 12)</option>
                                                <option <?= $row['region'] == "CARAGA" ? 'selected' : ''  ?> value="CARAGA">CARAGA</option>
                                                <option <?= $row['region'] == "BARMM" ? 'selected' : ''  ?> value="BARMM">Bangsamoro Autonomous Region in Muslim Mindanao (BARMM)</option>
                                            </select>

                                        </div>
                                        <button type="submit" class="btn-success border-3 px-2 text-uppercase rounded">Save</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>



        </div>

    </div>
</div>

<?php include('layouts/footer.php') ?>