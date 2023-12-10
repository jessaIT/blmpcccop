<?php include "layouts/headers.php"; ?>
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

    function displayErrorMessage(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            confirmButtonText: 'OK'
        });
    }
</script>

<?php

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION["username"];
?>
<div class="container-fluid py-3">

    <h3 class="text-dark border-left-success p-3" style="font-weight: bold;"> EVENTS</h3>

    <?php
    if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
        $successMessage = $_SESSION['success'];
        unset($_SESSION['success']);
        echo '<script>displaySuccessMessage("' . $successMessage . '");</script>';
    } else if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
        $errorMessage = $_SESSION['error'];
        unset($_SESSION['error']);
        echo '<script>displayErrorMessage("' . $errorMessage . '");</script>';
    }
    ?>

    <?php
    include "functions/connection.php";
    ?>

    <div class="row">
        <div class="col-6 g-2 mt-3 py-3">
            <div class="events-container" style="height: 800px; overflow-y: auto;">

                <?php
                include('functions/connection.php');

                $sql = "SELECT * FROM events_tbl ORDER BY event_date ASC";
                $result = $conn->query($sql);

                $eventsByMonth = [];

                while ($row = $result->fetch_assoc()) {
                    $eventDate = strtotime($row['event_date']);
                    $monthYear = date('F Y', $eventDate);

                    if (!isset($eventsByMonth[$monthYear])) {
                        $eventsByMonth[$monthYear] = [];
                    }

                    $eventsByMonth[$monthYear][] = $row;
                }

                $conn->close();
                ?>
                <!-- grouping the events based on months -->
                <?php foreach ($eventsByMonth as $month => $events) : ?>
                    <div class="month-card my-4">
                        <h5 class="text-dark text-uppercase">Events & activities for <span class="text-dark"><?= $month ?></span></h5>

                        <?php foreach ($events as $event) : ?>
                            <div class="card my-4">
                                <div class="card-body">
                                    <img src="functions/<?php echo $event['image_path']; ?>" class="img d-block mb-4" style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;" alt="Member Image">
                                    <h4 class="card-title text-dark" style="font-weight: bold;"><?= $event['event_name'] ?></h4>
                                    <i class="fa-solid fa-notes"></i>
                                    <div class="row">
                                        <p class="card-text"><?= $event['event_description'] ?></p>

                                    </div>
                                    <p class="card-text small text-primary">
                                        <?php
                                        $eventDate = new DateTime($event['event_date']);
                                        $currentDate = new DateTime();
                                        if ($eventDate < $currentDate) {
                                        ?>
                                    <div class="btn btn-sm" id="active-btn">
                                        <i class="fa-solid fa-check-circle" title="Completed Event"></i>
                                    </div>
                                <?php
                                        } else {
                                ?>
                                    <div class="btn btn-sm" id="inactive-btn-event" title="Upcoming Event">
                                        <i class="fa-solid fa-calendar" title="Upcoming Event"></i>
                                    </div>
                                <?php
                                        }
                                ?>
                                <span class="small text-dark"><?= $event['event_date'] ?></span>
                                </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
        <!-- main -->
        <div class="col-6 mb-4 g-2">
            <div class="row">
                <div class="row col-xl-6 col-md-12 mb-2 align-items-start">
                    <!-- <div class="col-1"> -->
                        <!-- <a href="announcement.php" class="btn btn-md btn-success mr-3" data-toggle="modal" data-target="#sendAnnouncementModal" title="Send announcement"><i class="fa-solid fa-comment-dots"></i></a> -->
                    <!-- </div> -->

                    <div class="col-auto">
                        <a href="#" class="btn btn-md mb-4 d-flex align-items-center w-auto gap-2" style="background-color: orangered; color: #fff;" data-toggle="modal" data-target="#addEventModal" title="New Event"><i class="fa-solid fa-plus"></i> Add Event </a>
                    </div>

                    <!-- <a href="#" class="mb-1 mt-0 small" data-toggle="modal" data-target="#sms_logs" title="View sms logs">VIEW SMS LOGS</a> -->

                </div>
                <div class="card border-left-dark shadow h-100 col-xl-12 col-md-12 col-12">
                    <div class="card-body">
                        <div class="calendar">
                            <div class="calendar-header">
                                <div class="row col-12 mx-auto">
                                    <div class="col">
                                        <button id="prevMonthBtn" class="btn"><i class="fa-solid fa-arrow-left"></i></button>
                                    </div>
                                    <div class="col text-center">
                                        <h4 id="currentMonthYear" class="text-success text-uppercase" style="font-weight: bold;"></h4>
                                    </div>
                                    <div class="col text-right">
                                        <button id="nextMonthBtn" class="btn"><i class="fa-solid fa-arrow-right"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center my-3">
                                <h3 id="currentMonthIndicator"></h3>
                            </div>
                            <table class="table table-bordered" id="calendarTable">

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

                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- this script generate the dates and months for the calendar -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const calendarBody = document.querySelector("#calendarTable tbody");
        const prevMonthBtn = document.querySelector("#prevMonthBtn");
        const nextMonthBtn = document.querySelector("#nextMonthBtn");
        const currentMonthYear = document.querySelector("#currentMonthYear");

        let currentDate = new Date();

        function generateCalendar() {
            const currentMonth = currentDate.getMonth();
            const currentYear = currentDate.getFullYear();

            calendarBody.innerHTML = "";

            const currentMonthIndicator = document.querySelector("#currentMonthIndicator");
            currentMonthIndicator.textContent = new Intl.DateTimeFormat("en-US", {
                year: "numeric",
                month: "long",
            }).format(currentDate);

            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay();

            let dayCount = 1;
            fetchEventDates().then(eventData => {
                for (let row = 0; row < 6; row++) {
                    const rowElement = document.createElement("tr");

                    for (let col = 0; col < 7; col++) {
                        const cell = document.createElement("td");
                        cell.style.width = "200px";

                        if (row === 0 && col < firstDayOfMonth) {
                            cell.textContent = "";
                        } else if (dayCount <= daysInMonth) {
                            const day = dayCount;
                            const formattedDate = currentYear + "-" + String(currentMonth + 1).padStart(2, '0') + "-" + String(day).padStart(2, '0');
                            const eventDataForDay = eventData[formattedDate];
                            if (eventDataForDay !== undefined) {
                                const eventBookmark = document.createElement("span");
                                eventBookmark.className = "col-12 event-bookmark";
                                eventBookmark.style.cssText = "font-size: 12px; background: green; color: #fff; border-radius: 10px; padding: 2px; width: 100%; cursor: pointer; display: flex; flex-direction: column; align-items: center;";

                                const icon = document.createElement("i");
                                icon.classList.add("fa-solid", "fa-bookmark");

                                const eventName = document.createElement("span");
                                eventName.textContent = eventDataForDay;
                                eventName.style.marginTop = "5px";

                                eventBookmark.appendChild(icon);
                                eventBookmark.appendChild(eventName);

                                const eventDate = new Date(formattedDate);
                                const currentDate = new Date();
                                if (eventDate < currentDate) {
                                    icon.classList.remove("fa-bookmark");
                                    icon.classList.add("fa-check-circle");
                                }

                                eventBookmark.dataset.eventDetails = eventDataForDay;

                                eventBookmark.addEventListener("click", function() {
                                    const icon = eventBookmark.querySelector("i");
                                    if (icon.classList.contains("fa-bookmark")) {
                                        icon.classList.remove("fa-bookmark");
                                        icon.classList.add("fa-check-circle");
                                    } else {
                                        icon.classList.remove("fa-check-circle");
                                        icon.classList.add("fa-bookmark");
                                    }

                                });

                                cell.innerHTML = `${dayCount}<br/>`;
                                cell.appendChild(eventBookmark);
                                cell.classList.add("event-day");
                            } else {
                                cell.textContent = dayCount;
                            }

                            dayCount++;
                        } else {
                            cell.textContent = "";
                        }

                        rowElement.appendChild(cell);
                    }

                    calendarBody.appendChild(rowElement);
                }

                function getRandomColor() {
                    const letters = "0123456789ABCDEF";
                    let color = "#";
                    for (let i = 0; i < 6; i++) {
                        color += letters[Math.floor(Math.random() * 16)];
                    }
                    return color;
                }
            });
        }

        function goToPreviousMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            generateCalendar();
        }

        function goToNextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            generateCalendar();
        }
        prevMonthBtn.addEventListener("click", goToPreviousMonth);
        nextMonthBtn.addEventListener("click", goToNextMonth);
        generateCalendar();
    });

    function fetchEventDates() {
        return fetch('fetch_events.php')
            .then(response => response.json())
            .catch(error => console.error(error));
    }
</script>
<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New event</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form class="user" method="post" action="functions/add_event.php" enctype="multipart/form-data">
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
                    </div>
                    <div class="row col-12 mx-auto">
                        <div class="col-12">

                            <div class="form-group">
                                <label for="event_date">Event Date</label>
                                <input type="date" class="form-control form-control" id="firstname" name="event_date" placeholder="Event Date" required>
                            </div>
                            <div class="form-group">
                                <label for="event_name">Event Name</label>
                                <input type="text" class="form-control form-control" name="event_name" placeholder="Event Name" required>
                            </div>
                            <div class="form-group">
                                <label for="event_description">Event Description</label>
                                <textarea name="event_description" required placeholder="Description" class="form-control" cols="30" rows="10"></textarea>
                            </div>

                            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Save Event</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Send Announcement Modal -->
<div class="modal fade" id="sendAnnouncementModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" id="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Announcement</h5>
                <button class="close" type="button text-success" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="send_sms.php" method="post">
                    <label for="message">What's new?</label>
                    <textarea id="message" name="message" class="form-control mb-0" rows="4" cols="50"></textarea><br><br>
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-paper-plane"></i> Send</button>



                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="sms_logs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" id="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">SMS Logs</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                include('functions/connection.php');
                $sql = "SELECT * FROM sms_logs";
                $result = $conn->query($sql);
                $conn->close();
                ?>


                <?php while ($row = $result->fetch_assoc()) : ?>

                    <div class="sms_logs_text">
                        <div class="row">
                            <div class="col-10 text-dark">
                                <p class="message"><span class="title">Message:</span> <?= $row['message'] ?></p>
                            </div>
                            <div class="col-1 small text-success">
                                <?php
                                $storedTimestamp = strtotime($row['date']);
                                $currentTimestamp = time();
                                $difference = $currentTimestamp - $storedTimestamp;
                                if ($difference >= 60 * 60 * 24 * 2) {
                                    echo date('Y-m-d', $storedTimestamp);
                                } elseif ($difference >= 60 * 60 * 24) {
                                    echo 'a day ago';
                                } elseif ($difference >= 60 * 60) {
                                    $hours = floor($difference / (60 * 60));
                                    echo $hours > 1 ? $hours . ' hours ago' : 'an hour ago';
                                } elseif ($difference >= 60) {
                                    $minutes = floor($difference / 60);
                                    echo $minutes > 1 ? $minutes . ' minutes ago' : 'a minute ago';
                                } else {
                                    echo 'just now';
                                }
                                ?>

                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .sms_logs_text {
        border-radius: 10px;
        padding: 10px;
        margin-bottom: 15px;
        box-shadow: 5px 5px 0 0 whitesmoke;
    }

    .title {
        font-weight: bold;
    }
</style>

<?php include "layouts/footer.php"; ?>