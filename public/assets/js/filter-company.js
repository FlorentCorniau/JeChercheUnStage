let companiesData;
const divFilterCompany = document.querySelector('#filter-companies-fetch');
const noResultsCompany = document.querySelector("#filter-company-no-results"); // Je sélectionne la div ou sera indiqué le msg d'aucun résultat

// On met un écouteur d'évènement sur le bouton cliquable "filtrer"
// ? id generate automaticaly with form type associated
const filterBtnCompany = document.querySelector("#company_filter_save").addEventListener('click', function(e){
    e.preventDefault();
    // ? id generate automaticaly with form type associated
    const selectedId = document.querySelector('#company_filter_industries').value;
    getCompaniesByIndustry(selectedId);
});

// On fait un call API pour checker les companies en fonction de l'Industry
async function getCompaniesByIndustry(industryId) 
{
    const response = await fetch("http://localhost/JeChercheUnStage/public/api/entreprises/secteur-activite/" + industryId);
    companiesData = await response.json();
    divFilterCompany.innerHTML = "";

    // Loop on the companies find and for any company find, I created a new company card
    for (let index = 0; index < companiesData.length; index++) {
        newCompanyCard(companiesData[index]);
    }

    // If there isn't company return => I diplay 
    if(companiesData.length === 0) {
        noResultsCompany.classList.add('alert', 'alert-danger', 'alert-dismissible', 'fade', 'show', 'mt-3');
        noResultsCompany.textContent = "Aucun résultat trouvé pour le secteur d'activité sélectionné.";
    }
    else {
        noResultsCompany.classList.remove('alert', 'alert-danger', 'alert-dismissible', 'fade', 'show', 'mt-3');
        noResultsCompany.textContent = "";
    }
}

function newCompanyCard(company) {
    const divColMd4 = document.createElement('div');
    divColMd4.classList.add('col-md-4', 'mt-4', 'mb-4');
    divFilterCompany.append(divColMd4);

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
    img.src = '/JeChercheUnStage/public/images/logo-company.jpeg';
    img.alt = "Image par défaut";
    divDflex.append(img);

    const divTextStart = document.createElement('div');
    divTextStart.classList.add('text-start');
    divTextStart.style.height = '15vh';
    divRowP3.append(divTextStart);

    const h5 = document.createElement('h5');
    h5.classList.add('mb-3', 'text-muted', 'fw-semibold');
    h5.textContent = company.name;
    divTextStart.append(h5);

    const p = document.createElement('p');
    p.textContent = company.description.substring(0, 50) + '...';
    divTextStart.append(p);

    const divDflexEnd = document.createElement('div');
    divDflexEnd.classList.add('d-flex', 'justify-content-end');
    divRowP3.append(divDflexEnd);

    const a = document.createElement('a');
    a.classList.add('btn', 'btn-outline-secondary', 'bi', 'bi-eye', 'btn-sm');
    a.href = '/JeChercheUnStage/public/entreprises/profil/' + company.id;
    a.textContent = ' Voir le profil';
    divDflexEnd.append(a);
}

// Fetch on the api route to get the data in JSON and display dynamically 
// all companies in DB
async function getAllCompaniesWithoutFilter() 
{
    const response = await fetch("http://localhost/JeChercheUnStage/public/api/entreprises");
    companiesData = await response.json();

    divFilterCompany.innerHTML = "";

    // On fait une boucle sur le nombre companies stockés dans companiesData qui correspond à la response API
    for (let index = 0; index < companiesData.length; index++) {
        newCompanyCard(companiesData[index]);
    }

    noResultsCompany.classList.remove('alert', 'alert-danger', 'alert-dismissible', 'fade', 'show', 'mt-3'); // 'btn', 'btn-danger', 'mt-3'
    noResultsCompany.textContent = "";
}

// Action pour réinitialiser le filtre
const BtnResetFilterCompany = document.querySelector("#company-reset-filter").addEventListener('click', function(e) {
    getAllCompaniesWithoutFilter();
});