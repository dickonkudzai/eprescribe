<?php
    include "../includes/header.php";
    include "../includes/sidebar.php";
    require_once '..\config\Config.php';
    use \config\Config;
    $config = new Config();
    $postData = $_POST;
    $getData = $_GET;
    $dbConnect = $config->databaseConnection();

    $query = "
        SELECT
            MONTHNAME(date_of_prescription) AS month,
            COUNT(*) AS record_count
        FROM
            eprescribe.prescriptions
        WHERE
            YEAR(date_of_prescription) = YEAR(CURDATE())
        GROUP BY
            MONTH(date_of_prescription);
    ";
    $statement = $dbConnect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $total='';
    $month = '';
    foreach ($result as $row)
    {
        # code...
        $month .= '"'.$row['month'].'",';
        $total .= $row['record_count'].',';

    }
    $month = substr($month, 0, -1);
    $total = substr($total, 0, -1);
?>
<script type="text/javascript">
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#292b2c';
    console.log('here',<?php echo $month?>);
    // Bar Chart Example
    var ctx = document.getElementById("myBarChart");
    var myLineChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?php echo $month?>],
            datasets: [{
                label: "Prescriptions",
                backgroundColor: "rgba(2,117,216,1)",
                borderColor: "rgba(2,117,216,1)",
                data: [<?php echo $total?>],
            }],
        },
        options: {
            scales: {
                xAxes: [{
                    time: {
                        unit: 'month'
                    },
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        maxTicksLimit: 6
                    }
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: 50,
                        maxTicksLimit: 5
                    },
                    gridLines: {
                        display: true
                    }
                }],
            },
            legend: {
                display: false
            }
        }
    });
</script>
