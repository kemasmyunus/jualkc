<?php
ob_start();
include('koneksi.php');
include('templates/header.php');
include('templates/sidebar.php');
if (!isset($_GET['id'])) {
    header('Location: pelacakan.php');
    ob_end_flush();
    exit;
}

$bayar_id = intval($_GET['id']);

// Fetch tracking information
$query = "SELECT * FROM tracking WHERE bayar_id = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, 'i', $bayar_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$tracking_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $tracking_data[] = $row;
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Detail Tracking Pesanan</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <h3>Proses Pesanan:</h3>
                <ul>
                    <?php foreach ($tracking_data as $data) : ?>
                        <li><?= htmlspecialchars($data['status']); ?> (<?= htmlspecialchars($data['coordinates']); ?>)</li>
                    <?php endforeach; ?>
                </ul>
                <div id="map" style="height: 400px;"></div>
            </div>
        </div>
    </section>
</div>

<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 5,
            center: {lat: -7.5, lng: 112} // Adjust based on your initial location
        });

        // Define your tracking points
        var locations = [
            <?php foreach ($tracking_data as $data) : ?>
                {lat: <?= explode(',', $data['coordinates'])[0]; ?>, lng: <?= explode(',', $data['coordinates'])[1]; ?>},
            <?php endforeach; ?>
        ];

        // Add markers
        locations.forEach(function(location, index) {
            var marker = new google.maps.Marker({
                position: location,
                map: map,
                title: 'Proses ' + (index + 1)
            });

            // Connect points with lines
            if (index > 0) {
                var line = new google.maps.Polyline({
                    path: [locations[index - 1], location],
                    geodesic: true,
                    strokeColor: '#FF0000',
                    strokeOpacity: 1.0,
                    strokeWeight: 2
                });
                line.setMap(map);
            }
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4s7iWCzerNrfMaldM5fC0m20rzMHeA3Q&callback=initMap"></script>

<?php
ob_end_flush();
include('templates/footer.php');
?>
