//global varibales 
var turn=3;
var count = 0;
var hover= true;
const clicked=[false, false, false, false, false, false, false, false, false];



/**
 * This function handles when the start/restart game Button is clicked
 * It resets the board and checks who's turn it is
 * 
 */
function handleStart(event){
    const turnButton = document.getElementById('turn');
    const winner = document.getElementById('winner');
    for (let i = 0; i < clicked.length; i++) {
        clicked[i]=false;
      }
    {
        $.ajax({
            type: 'POST',
            url: 'api.php',
            data: ({action: 'reset'}),
            success: function(response){
                console.log('Server resetting the game',  response);
                resetBoard(); //resets the UI
                turn = 0; //0 is x's turn
                let currentPlayer = response.currentPlayer;
                if(currentPlayer ===  'X'){
                    turnButton.textContent="X TURN"; //The server sets the first current player to X always so it should only be X TURN
                    winner.textContent = "";
                } 
                
            },
            error: function(xhr, status, error){
                console.log('Error server could not reset the game', error);
            }
        })
    }
}

/** 
 * This functions resets the UI to an empty board
 * 
 */
function resetBoard() {
    const buttons = document.querySelectorAll('.game-square');
    buttons.forEach(button => {
        button.textContent = '';
        button.style.backgroundColor = '';
        button.style.color= '';
    });
}

/**
 * This function is used to handle the Click of the player
 * on the board
 * 
 */
function handleClick(event, button_text){
    //game needs to be started before clicking
    if(turn == 3){
        alert("You must click on start game or restart game first")
    }else if (button_text != '' && hover == false){
        alert("can only play on an empty box")
    }else{
        const button = document.getElementById(event.target.id);
        const player = document.getElementById('turn');
        var tmp = parseInt(event.target.id)
        //check that players turn and the square is empty
        if (turn == 0 && clicked[tmp-1] == false ){
            //send to server and update the ui
            $.ajax({
                type: 'POST',
                url: 'api.php',
                data: ({action: 'play', index: tmp-1}),
                success: function(response){
                    console.log('X Playing',  response);
                    //Styling the board
                    button.style.color= 'red';
                    button.textContent = 'X';
                    turn ++;
                    clicked[tmp-1]=true;
                    //get the response (status, and comp_index)
                    let gameState = response.response.status; 
                    let comp_index = response.response.comp_Index;
                    let gamePlayer = response.response.player;
                    console.log('player', gamePlayer)

                    if(gamePlayer === 'O'){
                        computerPlay(comp_index, gameState);
                        scanGame('O');
                    }
                    if ((gameState == 'win' && gamePlayer === 'X') || gameState == 'draw' ){
                        scanGame('X');
                        player.textContent="Game is done x";
                    }
                    else{
                        player.textContent="O turn";
                        computerPlay(comp_index, gameState);
                    }
                    
                },
                error: function(xhr, status, error){
                    console.log('Error server could not reset the game', error);
                }
            })
                 
        }
    }
}


/**
 * When the computer plays
 * 
 */
function computerPlay(index, gameState) {
    const player = document.getElementById('turn');
    
    //index is passed as a parameter from server
    
    // Update clicked array based on received index
    clicked[index] = true;
    
    const square = document.getElementById(index+1);
    square.textContent = "O";
    turn--;
    count++;
    
    //gameState is passed as a parameter from server
    if (gameState == 'win' || gameState == 'draw' ){
        scanGame('O');
        player.textContent="Game is done";
    } else {
        player.textContent = "X turn";
    }
}

//function used to scan game after each play and know if somebody has won
function scanGame(player){
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
    //checking all possible ways to win for a winner
    if (square1.textContent == player && square2.textContent == player && square3.textContent == player ){
        winner.textContent=player + ' WON, Please restart game to continue';
        turn =3;
        gameState='done';
        setWinnerColors('1','2','3', player);
    } else if (square4.textContent == player && square5.textContent == player && square6.textContent == player ){
        winner.textContent= player + ' WON, Please restart game to continue';
        turn =3;
        gameState='done';
        setWinnerColors('4','5','6');
    } else if (square7.textContent == player && square8.textContent == player && square9.textContent == player ){
        winner.textContent=player + ' WON, Please restart game to continue';
        turn =3;
        gameState='done';
        setWinnerColors('7','8','9');
    } else if (square1.textContent == player && square4.textContent == player && square7.textContent == player ){
        winner.textContent=player + ' WON, Please restart game to continue';
        turn =3;
        gameState='done';
        setWinnerColors('1','4','7');
    } else if (square2.textContent == player && square5.textContent == player && square8.textContent == player ){
        winner.textContent=player + ' WON, Please restart game to continue';
        turn =3;
        gameState='done';
        setWinnerColors('2','5','8');
    }else if (square3.textContent == player && square6.textContent == player && square9.textContent == player ){
        winner.textContent=player + ' WON, Please restart game to continue';
        turn =3;
        gameState='done';
        setWinnerColors('3','6','9');
    }else if (square1.textContent == player && square5.textContent == player && square9.textContent == player ){
        winner.textContent=player + ' WON, Please restart game to continue';
        turn =3;
        gameState='done';
        setWinnerColors('1','5','9');
    }else if (square3.textContent == player && square5.textContent == player && square7.textContent == player ){
        winner.textContent=player + ' WON, Please restart game to continue';
        turn =3;
        gameState='done';
        setWinnerColors('3','5','7');
    }else if(count == 9){
        winner.textContent=' No winner, please restart';
        turn =3;
        gameState='done';
        setWinnerColors('0','0','0');
    }
}

//function used to change the colors of the squares to green to show the winning pattern
function setWinnerColors(id1, id2, id3){
    if (id1 != "0"){
        const square1 = document.getElementById(id1);
        const square2 = document.getElementById(id2);
        const square3 = document.getElementById(id3);
        square1.style.backgroundColor = 'green';
        square2.style.backgroundColor = 'green';
        square3.style.backgroundColor = 'green';
    }
    const buttons = document.querySelectorAll('.game-square');
    buttons.forEach(button => {
        if(button.id != id1 && button.id != id2 && button.id != id3 ){
            button.style.backgroundColor = 'grey';
        }
    });

}











//event listners for clicks and hovers on our buttons/squares
document.addEventListener( 'DOMContentLoaded', (event) => {

    const buttons= document.querySelectorAll('.game-square');
    const start_btn=document.querySelector('.start-game');
    buttons.forEach(button => {
        button.addEventListener('click', (event) => {
            const buttonText = button.textContent;
            handleClick(event, buttonText);
        });
    });
    
    //hovering only works if the game is started first
    if (turn != 3){
        buttons.forEach(button => {
            
            //can only hover on empty squares/buttons
            if (button.textContent == ''){
                button.addEventListener('mouseover', (event) => {
                    // Change the button's background color
                    var tmp = parseInt(event.target.id)
                    if(clicked[tmp-1] == false){
                        hover=true;
                        button.style.color='red'
                        button.textContent='X';
                    }

                  });
                   
                button.addEventListener('mouseout', (event) => {
                    hover = false;
                    var tmp = parseInt(event.target.id)
                    if (clicked[tmp-1] == false){
                        button.textContent='';
                        button.style.color = '';
                    }
                  });
                
            }
        });
    }

    
    start_btn.addEventListener('click', (event) => {
        handleStart(event)
    })
});


