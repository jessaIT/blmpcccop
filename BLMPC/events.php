<?php include "layouts/headers.php"; ?>
<?php include "layouts/sidebar.php"; ?>
<?php include "functions/connection.php"; ?>

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

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php include "layouts/topbar.php"; ?>

        <?php

        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("Location: login.php");
            exit;
        }

        $username = $_SESSION["username"];
        ?>
        <div class="container-fluid py-3">

            <?php
            if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
                $successMessage = $_SESSION['success'];
                unset($_SESSION['success']);
                echo '<script>displaySuccessMessage("' . $successMessage . '");</script>';
            }
            ?>
            <div class="row">
                <div class="col-xl-12 col-md-12 mb-4 g-2">
                    <div class="row">
                        <div class="card border-left-success shadow h-100  col-xl-3 col-md-12 col-12 mr-1">
                            <div class="card-body">

                                <p class="h4 text-success mb-3">UPCOMING EVENTS</p>
                                <p class="small">If there's upcoming event it will be shown below.</p>
                                <div class="table-responsive">
                                    <?php
                                    $sql1 = "SELECT * FROM events_tbl";
                                    $result1 = $conn->query($sql1);
                                    ?>
                                    <?php while ($row1 = $result1->fetch_assoc()) : ?>
                                        <div class="card border-left-success mb-3 col-11">

                                            <div class="card-body">



                                                <div class="row">
                                                    <div class="col-6">
                                                        <h5 class="card-title">Event: <u><?= $row1['event_name'] ?></u></h5>

                                                    </div>
                                                    <div class="col-6 text-right">
                                                        <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                                            <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">Remove</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <p class="card-text small">Description: <?= $row1['event_description'] ?></p>

                                            </div>
                                        </div>

                                        <!-- Delete Member Modal-->
                                        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete this member?</h5>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <div class="modal-body">
                                                            <p>You can't undo this.</p>
                                                        </div>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                        <button class="btn btn-warning btn-sm" type="button" data-dismiss="modal">Cancel</button>
                                                        <a class="btn btn-danger btn-sm" href="functions/delete_event.php?id=<?php echo $row1["id"]; ?>">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>

                        <!-- calendar -->
                        <div class="card border-left-success shadow h-100 col-xl-8 col-md-12 col-12">
                            <div class="card-body">

                                <?php
                                $currentMonth = date("m");
                                $currentYear = date("Y");
                                $sql = "SELECT * FROM events_tbl WHERE MONTH(event_date) = '$currentMonth' AND YEAR(event_date) = '$currentYear'";
                                $result = $conn->query($sql);
                                $conn->close();
                                ?>
                                <div class="calendar">
                                    <p class="h4 text-success text-uppercase" style="font-weight: bold;"><?php echo date("F Y"); ?></p>

                                    <table class="table table-bordered " id="calendarTable">

                                        <thead>
                                            <tr>
                                                <th>Sun</th>
                                                <th>Mon</th>
                                                <th>Tue</th>
                                                <th>Wed</th>
                                                <th>Thu</th>
                                                <th>Fri</th>
                                                <th>Sat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $firstDayOfMonth = date(
                                                "N",
                                                strtotime(date("Y-m-01"))
                                            );
                                            $totalDaysInMonth = date("t");
                                            $dayCount = 1;
                                            $dayCount = 1;
                                            $eventDates = [];
                                            while ($row = $result->fetch_assoc()) {
                                                $eventDate = date(
                                                    "Y-m-d",
                                                    strtotime($row["event_date"])
                                                );
                                                $eventDates[] = $eventDate;
                                                $eventDescriptions[$eventDate] =
                                                    $row["event_description"];
                                            }
                                            for ($row = 1; $row <= 6; $row++) {
                                                echo "<tr>";
                                                for ($col = 1; $col <= 7; $col++) {
                                                    if (
                                                        ($row == 1 &&
                                                            $col < $firstDayOfMonth) ||
                                                        $dayCount > $totalDaysInMonth
                                                    ) {
                                                        echo "<td></td>";
                                                    } else {
                                                        echo "<td>";
                                                        echo $dayCount;
                                                        $currentDate = date(
                                                            "Y-m-d",
                                                            strtotime(
                                                                $currentYear .
                                                                    "-" .
                                                                    $currentMonth .
                                                                    "-" .
                                                                    $dayCount
                                                            )
                                                        );
                                                        if (
                                                            in_array(
                                                                $currentDate,
                                                                $eventDates
                                                            )
                                                        ) {
                                                            echo '<div class="event-marker" data-tooltip="' .
                                                                htmlspecialchars(
                                                                    $eventDescriptions[$currentDate]
                                                                ) .
                                                                '"><i class="fas fa-fw fa-calendar text-success"></i></div>';
                                                        }
                                                        echo "</td>";
                                                        $dayCount++;
                                                    }
                                                }
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                    <a href="add-event.php" class="btn btn-sm col-12 btn-success mb-4">Add Event</a>
                                    <a href="announcement.php" class="btn btn-sm col-12 btn-success">Send Announcement</a>


                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "layouts/footer.php"; ?>