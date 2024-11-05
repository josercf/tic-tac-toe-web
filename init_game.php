<?php
// init_game.php
include 'db.php';

$player1 = "Player 1"; // Pode ser alterado para capturar de um formulário ou sessão
$player2 = "Player 2"; // Mesmo caso para o segundo jogador

// Estado inicial do tabuleiro e turno
$initialBoard = "---------"; // 9 posições vazias para o grid
$currentTurn = 'X';

// Insere um novo jogo na tabela
$sql = "INSERT INTO games (player1, player2, board_state, current_turn) VALUES ('$player1', '$player2', '$initialBoard', '$currentTurn')";

if ($conn->query($sql) === TRUE) {
    echo "Novo jogo iniciado! ID do jogo: " . $conn->insert_id;
} else {
    echo "Erro ao iniciar o jogo: " . $conn->error;
}

$conn->close();
?>
