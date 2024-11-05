<?php
// make_move.php
include 'db.php';

$gameId = $_POST['game_id'];
$cellIndex = $_POST['cell_index']; // índice do grid (0-8)
$player = $_POST['player']; // 'X' ou 'O'

// Obtém o estado atual do jogo
$sql = "SELECT board_state, current_turn, winner FROM games WHERE id = $gameId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $boardState = $row['board_state'];
    $currentTurn = $row['current_turn'];
    $winner = $row['winner'];

    // Verifica se é o turno correto e o jogo ainda está ativo
    if ($currentTurn === $player && $winner === NULL && $boardState[$cellIndex] === '-') {
        // Atualiza o estado do tabuleiro
        $boardState[$cellIndex] = $player;

        // Verifica se há um vencedor
        if (checkWinner($boardState, $player)) {
            $winner = $player;
            $sql = "UPDATE games SET board_state = '$boardState', winner = '$winner' WHERE id = $gameId";
        } else {
            // Alterna o turno
            $currentTurn = $player === 'X' ? 'O' : 'X';
            $sql = "UPDATE games SET board_state = '$boardState', current_turn = '$currentTurn' WHERE id = $gameId";
        }

        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => 'success', 'board_state' => $boardState, 'current_turn' => $currentTurn, 'winner' => $winner]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $conn->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Turno inválido ou jogo já encerrado.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Jogo não encontrado.']);
}

$conn->close();

function checkWinner($board, $player) {
    $winningCombinations = [
        [0, 1, 2], [3, 4, 5], [6, 7, 8], // Linhas
        [0, 3, 6], [1, 4, 7], [2, 5, 8], // Colunas
        [0, 4, 8], [2, 4, 6]             // Diagonais
    ];

    foreach ($winningCombinations as $combination) {
        if ($board[$combination[0]] === $player && $board[$combination[1]] === $player && $board[$combination[2]] === $player) {
            return true;
        }
    }

    return false;
}
?>
