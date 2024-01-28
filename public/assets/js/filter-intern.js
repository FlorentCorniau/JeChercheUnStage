let internsData;
const divFilter = document.querySelector('#filter-interns-fetch');
const noResults = document.querySelector("#filter-no-results"); // Je sélectionne la div ou sera indiqué le msg d'aucun résultat

// On met un écouteur d'évènement sur le bouton cliquable "filtrer"
const filterBtn = document.querySelector("#intern_filter_save").addEventListener('click', function(e){
    e.preventDefault();
    const selectedId = document.querySelector('#intern_filter_industries').value;
    console.log("L'id de l'industry selectionné est : " + selectedId);
    getInternsByIndustry(selectedId);
});

// On fait un call API pour checker les interns en fonction de l'Industry
async function getInternsByIndustry(industryId) 
{
    const response = await fetch("http://localhost/JeChercheUnStage/public/api/stagiaires/secteur-activite/" + industryId);
    internsData = await response.json();
    console.log(internsData);

    divFilter.innerHTML = "";

    // On fait une boucle sur le nombre d'interns stockés dans internsData qui correspond à la response API
    for (let index = 0; index < internsData.length; index++) {
        newInternCard(internsData[index]);
    }

    if(internsData.length === 0) {
        // alert alert-danger alert-dismissible fade show mt-3
        noResults.classList.add('alert', 'alert-danger', 'alert-dismissible', 'fade', 'show', 'mt-3');
        noResults.textContent = "Aucun résultat trouvé pour le secteur d'activité sélectionné.";
    }
    else {
        noResults.classList.remove('alert', 'alert-danger', 'alert-dismissible', 'fade', 'show', 'mt-3');
        noResults.textContent = "";
    }
}

function newInternCard(intern) {
    const divColMd4 = document.createElement('div');
    divColMd4.classList.add('col', 'mt-4', 'mb-4');
    divFilter.append(divColMd4);

    const divCard = document.createElement('div');
    divCard.classList.add('card');
    divColMd4.append(divCard);

    const divRowP3 = document.createElement('div');
    divRowP3.classList.add('row', 'p-3');
    divCard.append(divRowP3);

    const divDflex = document.createElement('div');
    divDflex.classList.add('d-flex', 'justify-content-center', 'mb-4');
    divRowP3.append(divDflex);

    const img = document.createElement('img');
    img.classList.add('img-fluid', 'rounded-circle', 'p-1');
    img.style.width = '100px';
    img.style.height = '100px';
    img.style.objectFit = 'cover';
    divDflex.append(img);

    if (intern.picture_name) {
        img.src = '/JeChercheUnStage/public/images/stagiaires/' + intern.picture_name;
        img.alt = "Une photo de profil d'un stagiaire";
    } else {
        img.src = '/JeChercheUnStage/public/images/stagiaires/logo-stagiaire.png';
        img.alt = "Image par défaut";
    }

    const divTextStart = document.createElement('div');
    divTextStart.classList.add('text-start');
    divTextStart.style.height = '15vh';
    divRowP3.append(divTextStart);

    const h5 = document.createElement('h5');
    h5.classList.add('mb-3', 'text-muted', 'fw-semibold');
    h5.textContent = intern.firstname + ' ' + intern.lastname;
    divTextStart.append(h5);

    const p = document.createElement('p');
    p.textContent = intern.description.substring(0, 50) + '...';
    divTextStart.append(p);

    const divDflexEnd = document.createElement('div');
    divDflexEnd.classList.add('d-flex', 'justify-content-end');
    divRowP3.append(divDflexEnd);

    const a = document.createElement('a');
    a.classList.add('btn', 'btn-outline-secondary', 'bi', 'bi-eye', 'btn-sm');
    a.href = '/JeChercheUnStage/public/stagiaires/profil/' + intern.id;
    a.textContent = ' Voir le profil';
    divDflexEnd.append(a);
}

// On fait un call API
async function getAllInternsWithoutFilter() 
{
    const response = await fetch("http://localhost/JeChercheUnStage/public/api/stagiaires");
    internsData = await response.json();
    console.log(internsData);

    divFilter.innerHTML = "";

    // On fait une boucle sur le nombre d'interns stockés dans internsData qui correspond à la response API
    for (let index = 0; index < internsData.length; index++) {
        newInternCard(internsData[index]);
    }

    noResults.classList.remove('alert', 'alert-danger', 'alert-dismissible', 'fade', 'show', 'mt-3'); // 'btn', 'btn-danger', 'mt-3'
    noResults.textContent = "";
}

const BtnResetFilter = document.querySelector("#intern-reset-filter").addEventListener('click', function(e) {
    console.log('click');
    getAllInternsWithoutFilter();
});