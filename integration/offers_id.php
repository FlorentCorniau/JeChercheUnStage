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

            <!-- Divs Nom de l'offre + missions attendues + profil recherché -->

            

            <div class="row bg-body-tertiary border d-flex align-items-center">



                <!-- Div Global gauche (Nom offre + descriptif dessous) -->

                <div class="col-md-6 p-4 ">

                    <!-- Nom de l'offre -->

                    <div class=" bg-white border p-4 ">

                        <h3 class="text-start fw-bold">Nom de l'offre</h3>

                        <p class="fw-semibold">Nom de l'entreprise - Location - Date</p>

                        <p>Secteur d'activité</p>

                    </div>

                

                    <!-- Missions attendues -->

                    <div class="bg-white p-4 border mt-4 " >

                        <h3 class="text-start fw-bold">Les missions attendues / Profil Recherché</h3>

                        <p>

                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos asperiores voluptatibus veniam recusandae perferendis minima?

                        </p>

                        <p>

                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos asperiores voluptatibus veniam recusandae perferendis minima?

                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos asperiores voluptatibus veniam recusandae perferendis minima?

                        </p>

                    </div>

                </div>



                <!--  Div Global droite (récap avec bouton postuler + images) -->

                <div class="col-md-6 p-4">

                    

                    <!-- Div Récap postuler -->

                    <div class=" bg-white border p-4 mt-4 " >

                        <h2 class="text-center fw-bold pb-2">Nom de l'offre</h2>

                        <p class="fw-semibold">Nom de l'entreprise - Location - Date</p>

                        <p>Secteur d'activité</p>



                        <div class="d-flex justify-content-center mt-3">

                            <button class="btn btn-primary">Postuler</button>

                        </div>

                    </div>



                    <!-- Gestion images entreprises  -->

                    <div class="bg-white border mt-5 p-5 row">

                        <h3 class="pb-2 fw-bold">Quelques images de l'entreprise...</h3>



                        <!-- Une image de l'album -->

                        <div class="row d-flex justify-content-between">

                            <div class="col-md-3 card shadow-sm p-2 mt-2 mb-2">

                                <img src="https://culture-rh.com/wp-content/uploads/2023/10/img-entreprise-dialogue-social-parle-quoi.jpg" alt="">

                            </div>



                            <div class="col-md-3 card shadow-sm p-2 mt-2 mb-2">

                                <img src="https://culture-rh.com/wp-content/uploads/2023/10/img-entreprise-dialogue-social-parle-quoi.jpg" alt="">

                            </div>



                            <div class=" col-md-3 card shadow-sm p-2 mt-2 mb-2">

                                <img src="https://culture-rh.com/wp-content/uploads/2023/10/img-entreprise-dialogue-social-parle-quoi.jpg" alt="">

                            </div>

                        </div>

                    </div>



                </div> 

                              

             </div><!-- fin Div Row  -->

                        </div><!-- Fin div container -->
   

    </main>

    <footer>

        <?php include 'footer.php'; ?>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>