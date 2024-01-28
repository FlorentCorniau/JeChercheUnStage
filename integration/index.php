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
                    <h2 class="mb-3">C'est quoi JeChercheUnStage ?</h2>

                    <p>Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.</p>

                    <p>Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.</p>

                    <p>Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.</p>

                    <div class="d-flex justify-content-center mt-3">
                        <button class="btn btn-dark">Je veux m'inscrire maintenant <i class="bi bi-arrow-right-circle"></i></button>
                    </div>
                </div>
            </div>

            <div class="row mt-5 bg-body-tertiary border"> 
                <div class="col-md-6 p-4 bg-white">
                    <?php include 'map.php'; ?>
                </div>
                        
                <div class="col-md-6 d-flex justify-content-around flex-column bg-body-tertiary ">
                    <div class="bg-white p-4 text-center rounded-4" >
                        <h4 class="mb-3 ">Nos entreprises partenaire</h4>
                        <div class="row d-flex align-items-between pb-2">
                            <?php include 'homepage_card.php'; ?>
                            <?php include 'homepage_card.php'; ?>
                            <?php include 'homepage_card.php'; ?>
                        </div>
                    </div>

                    <div class="col-md-12 p-4 bg-white mt-3 rounded-4">
                        <h4 class="text-center mb-3">Nos conseils</h4>
                        <p>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tenetur iusto, consequatur eos amet non soluta error maiores ipsam neque iste obcaecati nisi dolor blanditii. Eveniet vero iure laborum! Aliquam possimus molestiae facere recusandae accusantium alias ratione ea quisquam quos in.
                        </p>
                    </div>
                    
                </div>

                
            </div>

        </div>

        <div class="container mt-5">
            <div class="row d-flex justify-content-between bg-white">

                <!-- Section ... -->
                <div class="col-md-6 bg-body-tertiary border p-4">
                        <h4>Témoignages</h4>
                        
                        <!-- https://mdbootstrap.com/docs/standard/extended/testimonial-slider/ -->
                        <p>Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500</p>
                        
                        <p>
                            Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500
                        </p>
                </div>

                <!-- Section ... -->
                <div class="col-md-6 bg-body-tertiary border p-4">
                  
                    <h4>Statistiques</h4>
                    
                    <p>
                        Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500
                    </p>
                    
                    <canvas id="myChart"></canvas>

                </div>
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