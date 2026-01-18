const categories = [
    {
        id: 1,
        name: "Restaurants & Gastronomie",
        description: "Découvrez les meilleurs restaurants et offres culinaires",
        subcategories: [
            "Noeuf carotte",
            "Pizza & Pâtes",
            "Sushi & Cuisine asiatique",
            "Gastronomie française",
            "Burger & Fast-food",
            "Cuisine du monde",
            "Brunch & Petit-déjeuner",
            "Bars & Cocktails"
        ]
    },
    {
        id: 2,
        name: "Beauté & Bien-être",
        description: "Spa, massage, coiffure et soins esthétiques",
        subcategories: [
            "Spa & Hammam",
            "Massage relaxant",
            "Coiffure & Coloration",
            "Manucure & Pédicure",
            "Épilation",
            "Soins du visage",
            "Maquillage",
            "Tatouage & Piercing"
        ]
    },
    {
        id: 3,
        name: "Voyages & Hôtels",
        description: "Séjours, week-ends et escapades à prix réduits",
        subcategories: [
            "Week-end en France",
            "Hôtels de luxe",
            "Séjour à l'étranger",
            "Camping & Nature",
            "Escapade romantique",
            "Vacances en famille",
            "Croisières"
        ]
    },
    {
        id: 4,
        name: "Shopping & Mode",
        description: "Mode, accessoires et articles tendance",
        subcategories: [
            "Vêtements femme",
            "Vêtements homme",
            "Chaussures",
            "Sacs & Accessoires",
            "Bijoux & Montres",
            "Parfums",
            "Lunettes"
        ]
    },
    {
        id: 5,
        name: "Loisirs & Activités",
        description: "Activités sportives, culturelles et divertissements",
        subcategories: [
            "Parc d'attractions",
            "Cinéma & Spectacles",
            "Sport & Fitness",
            "Escape Game",
            "Cours de cuisine",
            "Activités nautiques",
            "Karting & Sensations fortes"
        ]
    },
    {
        id: 6,
        name: "Services",
        description: "Cours, formations et services professionnels",
        subcategories: [
            "Cours de langue",
            "Formation professionnelle",
            "Coaching sportif",
            "Photographie",
            "Réparation & Entretien",
            "Nettoyage à domicile"
        ]
    }
];

function createCustomDropdown() {
    const select = document.getElementById('categories');
    const container = document.createElement('div');
    container.className = 'category-menu';
    
    const button = document.createElement('button');
    button.id = 'categoryButton';
    button.textContent = 'Catégories';
    button.style.cssText = 'padding: 8px 16px; cursor: pointer; border: 1px solid #ccc; border-radius: 4px; background: white; font-size: 14px;';
    
    const dropdown = document.createElement('div');
    dropdown.className = 'dropdown-content';
    
    categories.forEach(cat => {
        const item = document.createElement('div');
        item.className = 'category-item';
        item.innerHTML = `
            <h4>${cat.name}</h4>
            <p>${cat.description}</p>
        `;
        
        if (cat.subcategories && cat.subcategories.length > 0) {
            const submenu = document.createElement('div');
            submenu.className = 'subcategory-menu';
            
            cat.subcategories.forEach(subcat => {
                const subitem = document.createElement('div');
                subitem.className = 'subcategory-item';
                subitem.textContent = subcat;
                
                subitem.addEventListener('click', (e) => {
                    e.stopPropagation();
                    button.textContent = `${cat.name} - ${subcat}`;
                    dropdown.classList.remove('show');
                });
                
                submenu.appendChild(subitem);
            });
            
            item.appendChild(submenu);
        }

        item.addEventListener('click', (e) => {
            if (e.target.classList.contains('category-item') || 
                e.target.tagName === 'H4' || 
                e.target.tagName === 'P') {
                button.textContent = cat.name;
                dropdown.classList.remove('show');
            }
        });
        
        dropdown.appendChild(item);
    });
    
    select.parentNode.insertBefore(container, select);
    container.appendChild(button);
    container.appendChild(dropdown);
    select.style.display = 'none';
    
    button.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.classList.toggle('show');
    });
    
    document.addEventListener('click', () => {
        dropdown.classList.remove('show');
    });
}

document.addEventListener('DOMContentLoaded', createCustomDropdown);



const products = [
            {
                id: 1,
                name: "Ordinateur portable",
                description: "PC portable haute performance pour professionnels",
                price: "899.99€",
                img: "images/cloche.jpg"
            },
            {
                id: 2,
                name: "MET UN TRUC BATARD",
                description: "y a rien a dire",
                price: "1€",
                img: "images/cadi.jpg"
            },
            {
                id: 3,
                name: "Ordinateur portable",
                description : "ordi 2",
                price: "1299.99€",
                img: "images/loupe.jpg"
            },
    ];

const cardContainer = document.getElementById('card-container');

function createCard(product) {
    const card = document.createElement('div');
    card.classList.add('ma-class', 'card');
    const cardImgContainer = document.createElement('div');
    const cardImg = document.createElement('img');
    cardImg.src = product.img;
    cardImg.alt = product.name;
    cardImgContainer.appendChild(cardImg);
    card.appendChild(cardImgContainer);
    const cardName = document.createElement('h3');
    cardName.textContent = product.name;
    card.appendChild(cardName);
    const cardDescription = document.createElement('p');
    cardDescription.textContent = product.description;
    card.appendChild(cardDescription);
    const cardPrice = document.createElement('p');
    cardPrice.classList.add('price');
    cardPrice.textContent = product.price;
    card.appendChild(cardPrice);
    cardContainer.appendChild(card);
}
products.forEach(product => {
    createCard(product);
});