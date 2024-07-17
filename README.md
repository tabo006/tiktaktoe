## Synopsis

This project is a single-player tic tac toe game built with HTML, CSS and JavaScript for the class CSI3140

## Code Example

The game's logic is encapsulated within the PHP files and the drawing by the JavaScript file (tictactoe.js). Here are some key functions of the Javascript file:

- `handleClick(event, button_text)`: Draws the user's move.
- `computerPlay()`: Draws the computer's move.
- `handleStart(event)`: Redraws the board of the game

## Motivation

The motivation behind this project is to create a single-player game as a learning exercise for the CSI3140 class. This project helps to understand the basics of HTML, CSS, and JavaScript and how they can be used together to create a functional and enjoyable web-based game.

## Installation

1. Clone this git repository.
2. Make sure you have php installed on your system.
3. Navigate to the repository and Open a terminal in the repository.
4. Run the command 
```bash 
php -S localhost:8000
```
5. Open http://localhost:8000/tictactoe.html in your web browser and you should be all set to play the game.

## PHP Files

## PHP Files

### api.php

This file handles the AJAX requests from the JavaScript frontend. It initializes the game and leaderboard objects, processes actions and returns the current game state and leaderboard.

- `reset`: Resets the game.
- `play`: Processes a move by the player and, if applicable, the computer.
- `set_initial`: Sets the state of the game as Initial, making the game unplayable until it is started.

### Leaderboard.php

This file contains the `Leaderboard` class, which tracks the scores of players X, O, and the number of draws. 

- `resetScore()`: Resets the scores.
- `incScore($player)`: Increments the score for the specified player.

### TicTacToeGame.php

This file contains the `TicTacToeGame` class, which manages the game board, the current player, and the game status. 

- `resetGame()`: Resets the game to the playing state.
- `play($index)`: Processes a player's move.
- `checkWin($player)`: Checks if the specified player has won.
- `checkDraw()`: Checks if the game is a draw.
- `getComputerMoveIndex()`: Determines the computer's move.
- `setInitialState()`: Resets the game to the initial state.

## Tests

### api_test.php

This test file uses cURL to send POST requests to the `api.php` file to test the game logic, including resetting the game, making moves, and checking the leaderboard.

### Leaderboard_test.php

This test file instantiates the `Leaderboard` class and tests its methods, including incrementing scores, resetting scores, and retrieving current scores.

### TicTacToeGame_test.php

This test file instantiates the `TicTacToeGame` class and tests its methods, including resetting the game, making moves, checking for wins or draws, and printing the board.

### Running Tests

To run the tests, you can use the command line to execute the test files individually using PHP after running. Tests are located in (/tests) folder
```bash 
php -S localhost:8000
``` 
For example:

```bash
php TestApi.php
php TestLeaderbd.php
php TicTacToeGame_test.php
```

## Contributors

The students of group 51 in the CSI3140 class: Abraham Tabo, 300228201 and Chloé Al-Frenn, 300211508

## Documentation

The documentation is available in the [Design System](/docs/design_system.md) file.
