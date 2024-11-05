<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Jogo da Velha</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <label>Id Jogo</label>
    <input type="number" id="game-id"/>
    <button onclick="gravarGameId();">Gravar ID</button>


    <div class="tic-tac-toe" id="board">
        <div class="cell" data-index="0"></div>
        <div class="cell" data-index="1"></div>
        <div class="cell" data-index="2"></div>
        <div class="cell" data-index="3"></div>
        <div class="cell" data-index="4"></div>
        <div class="cell" data-index="5"></div>
        <div class="cell" data-index="6"></div>
        <div class="cell" data-index="7"></div>
        <div class="cell" data-index="8"></div>
    </div>
    <script>
        const gameId = 1; // ID do jogo atual
        let currentPlayer = 'X'; // Jogador inicial

        document.querySelectorAll('.cell').forEach(cell => {
            cell.addEventListener('click', () => {
                const cellIndex = cell.getAttribute('data-index');
                makeMove(cellIndex);
            });
        });

        function gravarGameId(){
            gameId = document.getElementById("gameId").value;
        }

        function makeMove(cellIndex) {
            fetch('make_move.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `game_id=${gameId}&cell_index=${cellIndex}&player=${currentPlayer}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    updateBoard(data.board_state);
                    currentPlayer = data.current_turn;
                    if (data.winner) {
                        alert('Vencedor: ' + data.winner);
                    }
                } else {
                    alert(data.message);
                }
            });
        }

        function updateBoard(boardState) {
            document.querySelectorAll('.cell').forEach((cell, index) => {
                cell.textContent = boardState[index] === '-' ? '' : boardState[index];
            });
        }
    </script>
</body>
</html>
