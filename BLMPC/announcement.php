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
                <div class="col-xl-8 col-md-6 mx-auto py-3 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">

                            <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                                $event_date = $_POST['event_date'];
                                $outputDate = date('Y/m/d', strtotime($event_date));


                                $event_name = $_POST['event_name'];
                                $event_description = $_POST['event_description'];

                                $sql = "INSERT INTO events_tbl(event_name, event_date, event_description) VALUES('$event_name', '$event_date', '$event_description')";


                                if ($conn->query($sql) === TRUE) {
                                    $_SESSION['success'] = "New Event Added!";
                                }

                                header("Location: events.php");
                                exit;
                            }
                            ?>

                            <p><a href="events.php"> <i class="fas fa-fw fa-arrow-left text-success"></i></a>SEND ANNOUNCEMENT</p>

                            <form action="send_sms.php" method="post">
                                <label for="message">Message</label>
                                <textarea id="message" name="message" class="form-control" rows="4" cols="50"></textarea><br><br>
                                <input type="submit" class="btn btn-sm btn-success mx-auto" value="Send">
                            </form>
                        </div>
                    </div>
                </div>

            </div>



        </div>

    </div>
</div>

<?php include('layouts/footer.php') ?>