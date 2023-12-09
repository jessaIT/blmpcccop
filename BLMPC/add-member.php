<?php include('layouts/headers.php') ?>
<?php include('layouts/sidebar.php') ?>
<?php include('functions/connection.php') ?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php include('layouts/topbar.php') ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-md-12 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">

                            <p><a href="index.php"> <i class="fas fa-fw fa-arrow-left text-success"></i></a>ADD MEMBER
                            </p>

                            <form class="user" method="post" action="./functions/add_member.php">
                                <div class="row col-10 mx-auto">
                                    <div class="col-4">
                                        <p class="text-success h5">Name</p>
                                        <div class="form-group">
                                            <label for="firstname">Firstname</label>
                                            <input type="text" class="form-control form-control" id="firstname"
                                                name="firstname" placeholder="Juan">
                                        </div>
                                        <div class="form-group">
                                            <label for="middlename">Middle Name</label>
                                            <input type="text" class="form-control form-control" name="middlename"
                                                placeholder="Mendez">
                                        </div>
                                        <div class="form-group">
                                            <label for="lastname">Lastname</label>
                                            <input type="text" class="form-control form-control" id="lastname"
                                                name="lastname" placeholder="Dela Cruz">
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
                                        <p class="text-success h5">Basic Information</p>
                                        <div class="form-group">
                                            <label for="dob">Date of Birth</label>
                                            <input type="date" class="form-control form-control" id="dob" name="dob">
                                        </div>
                                        <div class="form-group">
                                            <label for="age">Age</label>
                                            <input type="number" class="form-control form-control" name="age">
                                        </div>
                                        <div class="form-group">
                                            <label for="pob">Place of Birth</label>

                                            <textarea name="pob" id="pob" cols="10" rows="4" class="form-control" placeholder="Place of Birth"></textarea>
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
                                            <input type="text" class="form-control form-control" id="tin" name="tin"
                                                aria-describedby="emailHelp" placeholder="TIN number">
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <p class="text-success h5 mb-6">Contact Information</p>
                                        <div class="form-group">
                                            <label for="mobile-number">Mobile Number</label>
                                            <input type="text" class="form-control form-control" id="mobile-number"
                                                name="mobile-number" placeholder="Mobile">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" class="form-control form-control" name="email"
                                                placeholder="Email Address">
                                        </div>


                                        <p class="text-success h5 mt-3">Address</p>
                                        <div class="form-group">
                                            <label for="zone">Zone</label>
                                            <input type="text" class="form-control form-control" id="zone" name="zone"
                                                placeholder="Zone">
                                        </div>
                                        <div class="form-group">
                                            <label for="brgy">Barangay</label>
                                            <input type="text" class="form-control form-control" name="brgy"
                                                placeholder="Barangay">
                                        </div>
                                        <div class="form-group">
                                            <label for="municipality">Municipality</label>
                                            <input type="text" class="form-control form-control" name="municipality"
                                                placeholder="Municipality">
                                        </div>
                                        <div class="form-group">
                                            <label for="province">Province</label>
                                            <input type="text" class="form-control form-control" name="province"
                                                placeholder="Province">
                                        </div>
                                        
                                        </div>

                                        <button type="submit" class="btn-success border-3 rounded">Save</button>
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