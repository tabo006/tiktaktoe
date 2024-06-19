var turn;
var count = 0;
function handleClick(event, button_text){
    
    if (button_text != ''){
        alert("can only play on an empty box")
    }else{
        const button = document.getElementById(event.target.id);
        const player = document.getElementById('turn');
        if (turn == 0){
            button.textContent = 'X';
            turn ++;
            count++;
            player.textContent="O TURN";
        }else if (turn == 1){
            button.textContent = 'O';
            turn --;
            count++;
            player.textContent="X TURN";
        }else{
            alert("You must click on start game or restart game first")
        }
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