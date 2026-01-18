const bete = [
  {
    name: "Raton Guerrier",
    rarity: "commun",
    chance: 60,
    img: "img/raton.png"
  },
  {
    name: "Loup Alpha",
    rarity: "rare",
    chance: 25,
    img: "img/loupAlpha.png"
  },
  {
    name: "Dragon Ancien",
    rarity: "épique",
    chance: 10,
    img: "img/dragon.png"
  },
  {
    name: "Esprit Légendaire",
    rarity: "légendaire",
    chance: 5,
    img: "img/esprit.jpg"
  },
];

const overlay = document.getElementById('overlay');
const closeBtn = document.getElementById('close');
const cardBtn = document.getElementById('card-btn');
const displayCard = document.getElementById('displayed-card');
const cardImg = document.getElementById('card-img');
const cardName = document.getElementById('card-name');
const cardRarity = document.getElementById('card-rarity');

function getCard() {
    const random = Math.floor(Math.random() * 100);
    let cumulative = 0;

    for (let i = 0; i < bete.length; i++) {
        cumulative += bete[i].chance;

        if (random < cumulative) {
            return bete[i];
        }
    }

    return bete[bete.length - 1];
}

function displayCardInfo(card) {
    cardImg.src = card.img;
    cardImg.alt = card.name;
    cardName.textContent = card.name;
    cardRarity.textContent = card.rarity.toUpperCase();
    cardRarity.className = `card-rarity ${card.rarity}`;
}

const closeModal = () => {
    overlay.classList.add('hidden');
    displayCard.classList.add('hidden');
};

closeBtn.addEventListener('click', closeModal);
overlay.addEventListener('click', closeModal);

document.addEventListener('keyup', (e) => {
    if (e.key === 'Escape' && !overlay.classList.contains('hidden')) {
        closeModal();
    }
});

cardBtn.addEventListener('click', () => {
    const selectedCard = getCard(); 
    displayCardInfo(selectedCard);
    overlay.classList.remove('hidden');
    displayCard.classList.remove('hidden');
});