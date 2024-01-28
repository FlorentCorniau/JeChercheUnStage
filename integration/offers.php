<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <main>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12 bg-body-tertiary border p-4">
                    <h2 class="text-center">Liste des offres de stage</h2>
                </div>
            </div>

            <div class="bg-body-tertiary border mt-5 p-5 row d-flex align-items-between justify-content-around">

                <?php include 'offers_card.php'; ?>
                <?php include 'offers_card.php'; ?>
                <?php include 'offers_card.php'; ?>
                <?php include 'offers_card.php'; ?>
                <?php include 'offers_card.php'; ?>
                <?php include 'offers_card.php'; ?>

            </div>

        </div>
    </main>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>

    <!-- Tests -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Informatique', 'Administratif', 'Aéronotique', 'Mécanique', 'Education', 'BTP'],
                datasets: [{
                    label: 'Les métiers les plus recherchés',
                    data: [19, 12, 3, 5, 8, 3],
                    borderWidth: 1,
                    backgroundColor: '', /* Couleur des bâtons */
                    borderColor: '' /* Couleur des bordures */

                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>