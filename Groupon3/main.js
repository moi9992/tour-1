const products = [
            {
                id: 1,
                name: "Ordinateur portable",
                description: "PC portable haute performance pour professionnels",
                price: "899.99€",
                image: "images/cloche.jpg"
            },
            {
                id: 2,
                name: "MET UN TRUC BATARD",
                description: "y a rien a dire",
                price: "1€",
                image: "images/cadi.jpg"
            },
            {
                id: 3,
                name: "Ordinateur portable",
                description : "ordi 2",
                price: "1299.99€",
                image: "images/loupe.jpg"
            },
    ];

const productsContainer = document.querySelector('.mainContainer');

 function createProductCards() {
            products.forEach(product => {
                const card = document.createElement('div');
                card.className = 'product-card';
                
                card.innerHTML = `
                    <img src="${product.image}" alt="${product.name}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22320%22 height=%22250%22%3E%3Crect fill=%22%23ddd%22 width=%22320%22 height=%22250%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 fill=%22%23999%22%3EImage%3C/text%3E%3C/svg%3E'">
                    <div class="product-info">
                        <div class="product-name">${product.name}</div>
                        <div class="product-description">${product.description}</div>
                        <div class="product-price">${product.price}</div>
                    </div>
                `;
                
                productsContainer.appendChild(card);
            });
        }
createProductCards();