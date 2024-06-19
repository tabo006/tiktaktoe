# Design System

## Fonts and Colors

### Fonts
The game uses the "Permanent Marker" font from Google Fonts for every text elements.

### Colors
- **Background**: `#f0f0f0`
- **Header Background**: `#333`
- **Header Text**: `#fff`
- **Button Background**: `#4caf50`
- **Button Hover Background**: `#45a049`
- **Table Border**: `#333`
- **Player X Color**: `red`
- **Player O Color**: `black`
- **Winner Background**: `green`
- **Non-winning Background**: `grey`

## Game Components

### Starting a New Game
Clicking the "Start / Restart game" button will initialize the game and reset the board.

### In-Game Play
The board consists of a 3x3 grid where the player and the computer take turns clicking squares to place their mark (X for the player, O for the computer). The game indicates whose turn it is.

### End of the Game
The game scans for a winner after each move. If a player wins, the winning line is highlighted, and the game indicates the winner. If all squares are filled without a winner, it declares no winner.
