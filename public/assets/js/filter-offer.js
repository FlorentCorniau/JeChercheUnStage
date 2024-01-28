// file to manage dynamically (without refresh) list of offers filter by by on industry 

let offersData;
const divFilterOffer = document.querySelector('#filter-offers-fetch');
const noResultsOffer = document.querySelector("#filter-offer-no-results"); // Je sélectionne la div ou sera indiqué le msg d'aucun résultat

// execution of method "getOffersByIndustry" when clik on button "#offer_filter_save"
// id generate automaticaly with form type associated
const filterBtnOffer = document.querySelector("#offer_filter_save").addEventListener('click', function(e){
    e.preventDefault();
    // ? id generate automaticaly with form type associated
    const selectedId = document.querySelector('#offer_filter_industries').value;
    getOffersByIndustry(selectedId);
});

// Fetch on the api route to get the data in JSON and display dynamically
async function getOffersByIndustry(industryId) 
{
    const response = await fetch("http://localhost/JeChercheUnStage/public/api/offres/secteur-activite/" + industryId);
    offersData = await response.json();
    divFilterOffer.innerHTML = "";

    // If there is offers return => I display all offer with loop
    if(offersData.length > 0) {
        // Loop on the offers find and for any offer find, I created a new offer card
        for (let index = 0; index < offersData.length; index++) {
            newOfferCard(offersData[index]);
        }
            noResultsOffer.classList.remove('alert', 'alert-danger', 'alert-dismissible', 'fade', 'show', 'mt-3');
            noResultsOffer.textContent = "";
        
    }
    else {
    // If there isn't offer return => I display a message '0 result find.'
        noResultsOffer.classList.add('alert', 'alert-danger', 'alert-dismissible', 'fade', 'show', 'mt-3');
        noResultsOffer.textContent = "Aucun résultat trouvé pour le secteur d'activité sélectionné.";
    }

}

// function to create a new offer card
function newOfferCard(offer) {
    
    // Create of element div col-md-4
    const divColMd4 = document.createElement('div');
    divColMd4.classList.add('col-md-4', 'mt-4', 'mb-4');
    divFilterOffer.append(divColMd4);

    // Create of element div card
    const divCard = document.createElement('div');
    divCard.classList.add('card');
    divColMd4.append(divCard);

    // Create of element div row p-3
    const divRowP3 = document.createElement('div');
    divRowP3.classList.add('row', 'p-3');
    divCard.append(divRowP3);

    // Create of element div col-md-4 d-flex justify-content-center
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

    // Create of element div col-md-8 text-start
    const divTextStart = document.createElement('div');
    divTextStart.classList.add('col-md-8', 'text-start');
    divTextStart.style.height = '15vh';
    divRowP3.append(divTextStart);

    // Create of element h5
    const h5 = document.createElement('h5');
    h5.classList.add('text-muted', 'fw-semibold');
    h5.textContent = offer.title; 
    divTextStart.append(h5);

    // Create of element p
    const p = document.createElement('p');
    p.textContent = offer.description.substring(0, 50) + '...'
    divTextStart.append(p);

    // Create of element div d-flex justify-content-end
    const divDflexEnd = document.createElement('div');
    divDflexEnd.classList.add('d-flex', 'justify-content-end');
    divRowP3.append(divDflexEnd);

    // Create of element a
    const a = document.createElement('a');
    a.classList.add('btn', 'btn-outline-secondary', 'btn-sm');
    a.href = '/JeChercheUnStage/public/offres/' + offer.id
    a.textContent = 'Détails'; 
    divDflexEnd.append(a);
}

// Fetch on the api route to get the data in JSON and display dynamically 
// all offers in DB
async function getAllOffersWithoutFilter() 
{
    const response = await fetch("http://localhost/JeChercheUnStage/public/api/offres");
    offersData = await response.json();
    divFilterOffer.innerHTML = "";

    if(offersData.length > 0) {
        // loop on all offersData fetch on api route and create a new card for any offer
        for (let index = 0; index < offersData.length; index++) {
            newOfferCard(offersData[index]);
        }
        noResultsOffer.classList.remove('alert', 'alert-danger', 'alert-dismissible', 'fade', 'show', 'mt-3');
        noResultsOffer.textContent = "";
    }
    else {
        // If there isn't offer return => I display a message '0 result find.'
        noResultsOffer.classList.add('alert', 'alert-danger', 'alert-dismissible', 'fade', 'show', 'mt-3');
        noResultsOffer.textContent = "Aucun résultat trouvé pour le secteur d'activité sélectionné.";
    }
}

// Action to reset the filter
const BtnResetFilterOffer = document.querySelector("#offer-reset-filter").addEventListener('click', function(e) {
    getAllOffersWithoutFilter();
});