const dino = document.getElementById("dino");
const scoreElement = document.getElementById("score");
const gameoverScreen = document.getElementById("gameover");
const restartBtn = document.getElementById("restart-btn");
const gameContainer = document.querySelector(".game");

let score = 0;
let isGameOver = false;

function jump() {
    if (isGameOver) return; 
    if (!dino.classList.contains("jump")) {
        dino.classList.add("jump");
        setTimeout(() => dino.classList.remove("jump"), 300);
    }
}

function createCactus() {
    if (isGameOver) return;

    const cactus = document.createElement("div");
    cactus.id = "cactus";
    gameContainer.appendChild(cactus);

    let pointAttribue = false;

    let moveInterval = setInterval(() => {
        if (isGameOver) {
            clearInterval(moveInterval);
            cactus.remove();
            return;
        }

        let dinoRect = dino.getBoundingClientRect();
        let cactusRect = cactus.getBoundingClientRect();

        if (dinoRect.right > cactusRect.left && dinoRect.left < cactusRect.right && dinoRect.bottom > cactusRect.top) {
            endGame();
        }

        if (cactusRect.right < dinoRect.left && !pointAttribue) {
            score++;
            scoreElement.innerHTML = score;
            pointAttribue = true;
        }

        if (cactusRect.right < 0) {
            clearInterval(moveInterval);
            cactus.remove();
        }
    }, 10);

    let nextCactusDelay = Math.random() * (2000 - 700) + 700; 
    setTimeout(createCactus, nextCactusDelay);
}

function endGame() {
    isGameOver = true;
    gameoverScreen.style.display = "block";
}

createCactus();

restartBtn.addEventListener("click", () => location.reload());
document.addEventListener("keydown", (e) => {
    if (e.code === "Space") jump();
});