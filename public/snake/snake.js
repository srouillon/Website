document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.getElementById("snakeCanvas");

    if (canvas.width !== canvas.height) {
        return alert("La taille du terrain de jeu est incorrect");
    }

    const ctx = canvas.getContext("2d");
    const boxSize = 15;
    const canvasSize = canvas.width;

    // Check de la config
    fetch('config.json')
        .then(response => response.json())
        .then(config => {

            // configuration
            let snake = [];
            let snakeColors = ["#61dafb"];
            let food = generateFood(config.foodAppearance);
            let foodPoints = config.foodPoints;
            let direction = null;
            let score = config.initialScore;
            let lives = config.initialLives;
            let gameTimeout;
            let flashingTimeout;
            let invulnerableCooldown = config.invulnerableCooldown;
            let invulnerable = false;
            let startTime = null;

            function draw() {
                if (direction) {
                    let newHead = {x: snake[0].x, y: snake[0].y};

                    switch (direction) {
                        case "up":
                            newHead.y--;
                            break;
                        case "down":
                            newHead.y++;
                            break;
                        case "left":
                            newHead.x--;
                            break;
                        case "right":
                            newHead.x++;
                            break;
                    }

                    // Check les collisions
                    if (
                        (newHead.x < 0 ||
                            newHead.y < 0 ||
                            newHead.x >= canvasSize / boxSize ||
                            newHead.y >= canvasSize / boxSize ||
                            collisionWithSelf(newHead, snake)) &&
                        invulnerable === false
                    ) {
                        if (lives > 0) {
                            invulnerable = true;
                            startTime = Date.now();
                            lives -= 1;
                            flashSnake();
                        } else {
                            alert("Game Over! Ton score: " + score + "\nTu n'as plus de vies!");
                            resetGame(config);
                        }
                    }

                    // Clear Canvas
                    ctx.clearRect(0, 0, canvasSize, canvasSize);

                    // Afficher le score
                    ctx.fillStyle = "#61dafb";
                    ctx.font = "20px Arial";
                    if (invulnerable) {
                        let timeRemaining = Math.max(0, Math.round((startTime + config.invulnerableCooldown - Date.now()) / 1000));
                        ctx.fillText("Invulnérable: " + timeRemaining, canvasSize / 2 - 70, 30);

                    } else {
                        ctx.fillText("Score: " + score + " Lives: " + lives, canvasSize / 2 - 70, 30);
                    }

                    drawSnake();
                    drawFood();

                    // Check si le serpent mange la nourriture
                    if (newHead.x === food.x && newHead.y === food.y) {
                        if (food.color === "#4CAF50") {
                            score += foodPoints.green;
                        } else if (food.color === "#FF5722") {
                            score += foodPoints.red;
                        } else if (food.color === "#2196F3") {
                            lives += 1;
                            score += foodPoints.blue;
                        } else if (food.color === "#FF00FF") {
                            score += foodPoints.magenta;
                        } else {
                            score -= 1;
                        }

                        newHead = {x: snake[0].x, y: snake[0].y};
                        snakeColors.push(food.color);

                        // Nouvelle nourriture
                        food = generateFood(config.foodAppearance);
                    } else {
                        snake.pop();
                    }

                    snake.unshift(newHead);
                    gameTimeout = setTimeout(draw, 100);
                }
            }

            function flashSnake() {
                // Si le serpent doit flash, il est forcément dans l'état invulnérable
                if (invulnerable) {
                    ctx.clearRect(0, 0, canvasSize, canvasSize);
                    if (flashingTimeout == null) {
                        flashingTimeout = setTimeout(function () {
                            invulnerable = false;
                            flashingTimeout = null;
                            startTime = null;
                        }, invulnerableCooldown);
                    }
                    gameTimeout = setTimeout(flashSnake, 500);
                }
                // s'il ne doit pas flash, on continue
                else {
                    drawSnake();
                    drawFood();
                }
            }

            function generateFood(appearance) {
                const rand = Math.round(Math.random() * 100);
                let color;

                if (appearance.green.min <= rand && rand <= appearance.green.max) {
                    color = "#4CAF50";
                }
                else if (appearance.red.min <= rand && rand <= appearance.red.max) {
                    color = "#FF5722";
                }
                else if (appearance.blue.min <= rand && rand <= appearance.blue.max) {
                    color = "#2196F3";
                }
                else if (appearance.magenta.min <= rand && rand <= appearance.magenta.max) {
                    color = "#FF00FF";
                }
                else {
                    color = "#FFFFFF";
                }
                return {
                    x: Math.floor(Math.random() * (canvasSize / boxSize)),
                    y: Math.floor(Math.random() * (canvasSize / boxSize)),
                    color: color,
                };
            }

            function collisionWithSelf(head, array) {
                for (let i = 1; i < array.length; i++) {
                    if (head.x === array[i].x && head.y === array[i].y) {
                        return true;
                    }
                }
                return false;
            }

            function resetGame(config) {
                clearTimeout(gameTimeout);
                clearTimeout(flashingTimeout);
                snakeColors = ["#61dafb"];
                snake = [];
                direction = null;
                score = config.initialScore;
                food = generateFood(config.foodAppearance);
                draw();
            }

            function drawSnake() {
                for (let i = 0; i < snake.length; i++) {
                    ctx.fillStyle = i === 0 ? "#61dafb" : snakeColors[i];
                    ctx.beginPath();
                    ctx.arc(snake[i].x * boxSize + boxSize / 2, snake[i].y * boxSize + boxSize / 2, boxSize / 2, 0, 2 * Math.PI);
                    ctx.fill();
                }
            }

            function drawFood() {
                ctx.fillStyle = food.color;
                ctx.beginPath();
                ctx.arc(food.x * boxSize + boxSize / 2, food.y * boxSize + boxSize / 2, boxSize / 2, 0, 2 * Math.PI);
                ctx.fill();
            }

            document.addEventListener("keydown", function (e) {
                if (!direction && ["ArrowUp", "ArrowDown", "ArrowLeft", "ArrowRight"].includes(e.key)) {
                    const message = document.getElementById("startGame");
                    if (message !== null) {
                        message.remove();
                    }
                    direction = e.key.replace("Arrow", "").toLowerCase();
                    snake = [{x: 10, y: 10, color: food.color}];
                    draw();
                } else {
                    switch (e.key) {
                        case "ArrowUp":
                            if (direction !== "down") {
                                direction = "up";
                            }
                            break;
                        case "ArrowDown":
                            if (direction !== "up") {
                                direction = "down";
                            }
                            break;
                        case "ArrowLeft":
                            if (direction !== "right") {
                                direction = "left";
                            }
                            break;
                        case "ArrowRight":
                            if (direction !== "left") {
                                direction = "right";
                            }
                            break;
                    }
                }
            });

            resetGame(config);
        })
        .catch(error => console.error('Erreur de config : ', error));
});
