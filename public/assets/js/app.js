let statsJSON = {};
let myChart;

async function showStatsJSON() {
    const response = await fetch("http://localhost/JeChercheUnStage/public/api/stats");
    statsJSON = await response.json();

    let labels = statsJSON.map(function(e) {
        return e.name; // Le nom (ex Informatique)
    });

    let data = statsJSON.map(function(e) {
        return e.data; // La valeur (ex 10)
    });

    // Si un graphique est déjà enregistré, on le destroy
    if (myChart) {
        myChart.destroy();
    }

    // Mettre à jour les données du graphique
    updateChart(labels, data);
}

function updateChart(labels, data) {
    const ctx = document.querySelector('#statistiques');
    myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Les métiers les plus recherchés',
                data: data,
                borderWidth: 1,
                backgroundColor: '', // Couleur des bâtons
                borderColor: '' // Couleur des bordures
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
}

// On ajoute un écouteur d'évènement avec une fonction anonyme, et lors du clic de l'utilisateur sur ce bouton qui a l'id #actualizeStatsJob on appel showStatsJSON()
document.querySelector("#actualizeStatsJob").addEventListener('click', function(e) {
    showStatsJSON();
});

// Appelé au chargement de la page :
document.addEventListener("DOMContentLoaded", (event) => {
    showStatsJSON();
});
