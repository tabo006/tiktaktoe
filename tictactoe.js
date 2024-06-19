var turn;
var count = 0;
function handleClick(event, button_text){
    if(turn == 3){
        alert("You must click on start game or restart game first")
    } else  if (button_text != ''){
        alert("can only play on an empty box")
    }else{
        const button = document.getElementById(event.target.id);
        const player = document.getElementById('turn');
        if (turn == 0){
            button.textContent = 'X';
            turn ++;
            count++;
            if (count > 4){
                scanXGame();
                player.textContent="Game is done";
            }else{
                player.textContent="O turn";
            }
            
        }else if (turn == 1){
            button.textContent = 'O';
            turn --;
            count++;
            if (count > 4){
                scanOGame();
                player.textContent="Game is done";
            }else{
                player.textContent="X turn";
            }
        }
    }
}
function scanXGame(){
    const square1 = document.getElementById('1');
    const square2 = document.getElementById('2');
    const square3 = document.getElementById('3');
    const square4 = document.getElementById('4');
    const square5 = document.getElementById('5');
    const square6 = document.getElementById('6');
    const square7 = document.getElementById('7');
    const square8 = document.getElementById('8');
    const square9 = document.getElementById('9');
    const winner = document.getElementById('winner');
    if (square1.textContent == "X" && square2.textContent == "X" && square3.textContent == "X" ){
        winner.textContent='X WON, Please restart game to continue'
        turn =3;
    } else if (square4.textContent == "X" && square5.textContent == "X" && square6.textContent == "X" ){
        winner.textContent='X WON, Please restart game to continue'
        turn =3;
    } else if (square7.textContent == "X" && square8.textContent == "X" && square9.textContent == "X" ){
        winner.textContent='X WON, Please restart game to continue'
        turn =3;
    } else if (square1.textContent == "X" && square4.textContent == "X" && square7.textContent == "X" ){
        winner.textContent='X WON, Please restart game to continue'
        turn =3;
    } else if (square2.textContent == "X" && square5.textContent == "X" && square8.textContent == "X" ){
        winner.textContent='X WON, Please restart game to continue'
        turn =3;
    }else if (square3.textContent == "X" && square6.textContent == "X" && square9.textContent == "X" ){
        winner.textContent='X WON, Please restart game to continue'
        turn =3;
    }else if (square1.textContent == "X" && square5.textContent == "X" && square9.textContent == "X" ){
        winner.textContent='X WON, Please restart game to continue'
        turn =3;
    }else if (square3.textContent == "X" && square5.textContent == "X" && square7.textContent == "X" ){
        winner.textContent='X WON, Please restart game to continue'
        turn =3;
    }
}
function scanOGame(){
    const square1 = document.getElementById('1');
    const square2 = document.getElementById('2');
    const square3 = document.getElementById('3');
    const square4 = document.getElementById('4');
    const square5 = document.getElementById('5');
    const square6 = document.getElementById('6');
    const square7 = document.getElementById('7');
    const square8 = document.getElementById('8');
    const square9 = document.getElementById('9');
    const winner = document.getElementById('winner');
    if (square1.textContent == "O" && square2.textContent == "O" && square3.textContent == "O" ){
        winner.textContent='O WON, Please restart game to continue'
        turn =3;
    } else if (square4.textContent == "O" && square5.textContent == "O" && square6.textContent == "O" ){
        winner.textContent='O WON, Please restart game to continue'
        turn =3;
    } else if (square7.textContent == "O" && square8.textContent == "O" && square9.textContent == "O" ){
        winner.textContent='O WON, Please restart game to continue'
        turn =3;
    } else if (square1.textContent == "O" && square4.textContent == "O" && square7.textContent == "O" ){
        winner.textContent='O WON, Please restart game to continue'
        turn =3;
    } else if (square2.textContent == "O" && square5.textContent == "O" && square8.textContent == "O" ){
        winner.textContent='O WON, Please restart game to continue'
        turn =3;
    }else if (square3.textContent == "O" && square6.textContent == "O" && square9.textContent == "O" ){
        winner.textContent='O WON, Please restart game to continue'
        turn =3;
    }else if (square1.textContent == "O" && square5.textContent == "O" && square9.textContent == "O" ){
        winner.textContent='O WON, Please restart game to continue'
        turn =3;
    }else if (square3.textContent == "O" && square5.textContent == "O" && square7.textContent == "O" ){
        winner.textContent='O WON, Please restart game to continue'
        turn =3;
    }
}

function resetBoard() {
    const buttons = document.querySelectorAll('.game-square');
    buttons.forEach(button => {
        button.textContent = '';
    });
}

function handleStart(event){
    turn = Math.floor(Math.random() * 2);
    count = 0;
    resetBoard();

    const button = document.getElementById('turn');
    const winner = document.getElementById('winner');
    winner.textContent='Game in process'
    if (turn == 0){
        button.textContent="X TURN"
    }else if (turn ==1){
        button.textContent="O TURN"
    }
}
document.addEventListener( 'DOMContentLoaded', (event) => {

    const buttons= document.querySelectorAll('.game-square');
    const start_btn=document.querySelector('.start-game');
    buttons.forEach(button => {
        button.addEventListener('click', (event) => {
            const buttonText = button.textContent;
            handleClick(event, buttonText);
        });
    });
    
    start_btn.addEventListener('click', (event) => {
        handleStart(event)
    })
});