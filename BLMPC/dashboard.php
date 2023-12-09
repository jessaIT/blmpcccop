<?php include('headers.php') ?>
<?php include('sidebar.php') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<div id="content-wrapper" class="d-flex flex-column">
    <!-- ... rest of your code ... -->

    <div class="container-fluid m-3">
        <!-- ... rest of your code ... -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <!-- Area Chart -->
                <div class="card shadow mb-4">
                    <!-- ... rest of your code ... -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                        <!-- ... rest of your code ... -->
                    </div>
                </div>

                <!-- Bar Chart -->
                <div class="card shadow mb-4">
                    <!-- ... rest of your code ... -->
                    <div class="card-body">
                        <div class="chart-bar">
                            <canvas id="myBarChart"></canvas>
                        </div>
                        <!-- ... rest of your code ... -->
                    </div>
                </div>
            </div>

            <!-- Donut Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- ... rest of your code ... -->
                    <div class="card-body">
                        <div class="chart-pie pt-4">
                            <canvas id="myPieChart"></canvas>
                        </div>
                        <!-- ... rest of your code ... -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>



<script>
    // Chart.js code for the Area Chart
    var ctxArea = document.getElementById('myAreaChart').getContext('2d');
    var myAreaChart = new Chart(ctxArea, {
        type: 'line', // You can change the chart type here
        data: {
            // Example data for the chart
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Example Data',
                data: [10, 20, 15, 25, 30, 18],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            // Chart options
        }
    });

    // Chart.js code for the Bar Chart
    var ctxBar = document.getElementById('myBarChart').getContext('2d');
    var myBarChart = new Chart(ctxBar, {
        type: 'bar', // You can change the chart type here
        data: {
            // Example data for the chart
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: 'Example Data',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            // Chart options
        }
    });

    // Chart.js code for the Donut Chart
    var ctxPie = document.getElementById('myPieChart').getContext('2d');
    var myPieChart = new Chart(ctxPie, {
        type: 'doughnut', // You can change the chart type here
        data: {
            // Example data for the chart
            labels: ['Red', 'Blue', 'Yellow'],
            datasets: [{
                data: [30, 40, 20],
                backgroundColor: ['rgba(255, 99, 132, 0.8)', 'rgba(54, 162, 235, 0.8)', 'rgba(255, 206, 86, 0.8)'],
                borderWidth: 1
            }]
        },
        options: {
            // Chart options
        }
    });
</script>
