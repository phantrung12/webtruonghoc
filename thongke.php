<?php
require_once "include/header.php";
require_once "include/navbar.php";
require_once("security.php");


    $sql ="SELECT * FROM nganhts ORDER BY manganh";
    $result = mysqli_query($conn,$sql);
    $chart_data="";
    while ($row = mysqli_fetch_array($result)) {
        $majorid[] = $row ['manganh'];
        $majorname[]  = $row['tennganh'];
        $ct[] = $row['chitieu'];
    }

    $sql2 = "SELECT nganhts, COUNT(nganhts) AS soluong FROM donts GROUP BY nganhts";
    $result2 = mysqli_query($conn,$sql2);
    while ($row = mysqli_fetch_array($result2)) {
        $manganh[] = $row ['nganhts'];
        $sodon[]  = $row['soluong'];
    }

?>
<div>
    <div class="container align-center">
        <div style="width:90%;text-align:center">
            <h2 class="page-header">Analytics Reports </h2>
            <div>Product </div>
            <canvas id="chartjs_bar"></canvas>
        </div>
    </div>
    <div class="container">
        <canvas id="form_chart"></canvas>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<script type="text/javascript">
var ctx = document.getElementById("chartjs_bar").getContext('2d');
var majorchart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($majorname); ?>,
        datasets: [{
            backgroundColor: [
                "#5969ff",
                "#33333",
                "#25d5f2",
                "#ffc750",
                "#2ec551",
                "#7040fa",
                "#ff004e",
                "#5969ff",
                "#ff407b",
                "#25d5f2",
                "#ffc750",
                "#2ec551"
            ],
            data: <?php echo json_encode($ct); ?>,
        }]
    },
    options: {
        legend: {
            display: true,
            position: 'bottom',

            labels: {
                fontColor: '#71748d',
                fontFamily: 'Circular Std Book',
                fontSize: 14,
            }
        },


    }
});
var fc = document.getElementById("form_chart").getContext('2d');
var formchart = new Chart(fc, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($majorname); ?>,
        datasets: [{
            backgroundColor: [
                "rgba(238, 68, 68, 0.4)"
            ],
            data: <?php echo json_encode($sodon); ?>,
        }]
    },
    options: {
        legend: {
            display: true,
            position: 'bottom',

            labels: {
                fontColor: '#71748d',
                fontFamily: 'Circular Std Book',
                fontSize: 14,
            }
        },


    }
});
</script>

<?php
require_once "include/scripts.php";
require_once "include/footer.php";
?>