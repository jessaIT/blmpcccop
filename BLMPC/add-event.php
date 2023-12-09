<?php include('layouts/headers.php') ?>
<?php include('layouts/sidebar.php') ?>
<?php include('functions/connection.php') ?>

<div id="content-wrapper" class="d-flex flex-column">

<div id="content">
    <?php include('layouts/topbar.php') ?>
    <div class="container-fluid">
<div class="row">
    <div class="col-xl-5 col-md-5 mx-auto py-3 mb-4">
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

<p><a href="events.php"> <i class="fas fa-fw fa-arrow-left text-success"></i></a>ADD EVENT</p>
                
                <form class="user" method="post" action="">
                    <div class="row col-12 mx-auto">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="event_date">Event Date</label>
                                <input type="date" class="form-control form-control" id="firstname"
                                    name="event_date" placeholder="Event Date" required>
                            </div>
                            <div class="form-group">
                                <label for="event_name">Event Name</label>
                                <input type="text" class="form-control form-control" name="event_name"
                                    placeholder="Event Name" required>
                            </div>
                            <div class="form-group">
                                <label for="event_description">Event Description</label>
                                <textarea name="event_description" required placeholder="Description" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                            
                            <input type="submit" class="btn btn-sm btn-success" value="Save Event">

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