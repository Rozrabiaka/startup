import {updateGround, setupGround} from "./ground.js"
import {updateDino, setupDino, getDinoRect, setDinoLose} from "./dino.js"
import {updateCactus, setupCactus, getCactusRects} from "./cactus.js"

const WORLD_WIDTH = 100;
const WORLD_HEIGHT = 30;
const SPEED_SCALE_INCREASE = 0.00001;

const worldElem = document.querySelector("[data-world]");
const scoreElem = document.querySelector("[data-score]");
const startScreenElem = document.querySelector("[data-start-screen]");
let gameStarted = false;
let detect = new MobileDetect(window.navigator.userAgent);

if (detect.mobile()) document.getElementsByClassName('game-text')[0].innerText = 'Натисніть на екран';

setPixelToWorldScale();
window.addEventListener("resize", setPixelToWorldScale);
spaceClicked();

let lastTime;
let speedScale;
let score;

function update(time) {
    if (lastTime == null) {
        lastTime = time;
        window.requestAnimationFrame(update);
        return
    }
    const delta = time - lastTime;

    updateGround(delta, speedScale);
    updateDino(delta, speedScale);
    updateCactus(delta, speedScale);
    updateSpeedScale(delta);
    updateScore(delta);
    if (checkLose()) return handleLose();

    lastTime = time;
    window.requestAnimationFrame(update)
}

function checkLose() {
    const dinoRect = getDinoRect();
    return getCactusRects().some(rect => isCollision(rect, dinoRect))
}

function isCollision(rect1, rect2) {
    return (
        rect1.left < rect2.right &&
        rect1.top < rect2.bottom &&
        rect1.right > rect2.left &&
        rect1.bottom > rect2.top
    )
}

function updateSpeedScale(delta) {
    speedScale += delta * SPEED_SCALE_INCREASE
}

function updateScore(delta) {
    score += delta * 0.01;
    scoreElem.textContent = Math.floor(score)
}

function handleStart() {
    lastTime = null;
    speedScale = 1;
    score = 0;
    audio();
    setupGround();
    setupDino();
    setupCactus();
    startScreenElem.classList.add("hide");
    window.requestAnimationFrame(update)
}

function audio() {
    const audio = new Audio();
    audio.src = '/audio/okay-letsgo.mp3';
    audio.autoplay = true;
}

function spaceClicked() {
    document.body.onkeyup = function (e) {
        if ((e.key == " " ||
            e.code == "Space" ||
            e.keyCode == 32) &&
            gameStarted === false
        ) {
            gameStarted = true;
            handleStart()
        }
    };

    game.addEventListener('click', function (e) {
        if (gameStarted === false) {
            gameStarted = true;
            handleStart()
        }
    }, true);
}

function handleLose() {
    gameStarted = false;
    setDinoLose();
    setTimeout(() => {
        spaceClicked();
        startScreenElem.classList.remove("hide");
    }, 100)
}

function setPixelToWorldScale() {
    let worldToPixelScale;
    if (window.innerWidth / window.innerHeight < WORLD_WIDTH / WORLD_HEIGHT) {
        worldToPixelScale = window.innerWidth / WORLD_WIDTH
    } else {
        worldToPixelScale = window.innerHeight / WORLD_HEIGHT
    }

    //worldElem.style.width = `${WORLD_WIDTH * worldToPixelScale}px`;
    worldElem.style.width = '100%';
    worldElem.style.height = `${WORLD_HEIGHT * worldToPixelScale}px`;
}
