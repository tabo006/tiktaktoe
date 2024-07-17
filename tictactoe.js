//global varibales
var gameDone = false;

/**
 * This function will update the score in the leaderboard
 * fetching the vaue from the server.
 */
function updateLeaderboard() {
  $.ajax({
    type: "POST",
    url: "api.php",
    data: { action: "get_leaderboard" },
    success: function (response) {
      if (response.leaderboard) {
        document.getElementById("score-x").textContent = response.leaderboard.X;
        document.getElementById("score-o").textContent = response.leaderboard.O;
      }
    },
    error: function (xhr, status, error) {
      console.log("Error fetching leaderboard", error);
    },
  });
}

/**
 * This function handles when the start/restart game Button is clicked
 * It resets the board and checks who's turn it is
 */
function handleStart(event) {
  const turnButton = document.getElementById("turn");
  const winner = document.getElementById("winner");
  gameDone = false;
  $.ajax({
    type: "POST",
    url: "api.php",
    data: { action: "reset" },
    success: function (response) {
      console.log("Server resetting the game", response);
      resetBoard(); //resets the UI
      let currentPlayer = response.currentPlayer;
      if (currentPlayer === "X") {
        turnButton.textContent = "X TURN"; //The server sets the first current player to X always so it should only be X TURN
        winner.textContent = "";
      }
      updateLeaderboard();
    },
    error: function (xhr, status, error) {
      console.log("Error server could not reset the game", error);
    },
  });
}

/**
 * This functions resets the UI to an empty board
 */
function resetBoard() {
  const buttons = document.querySelectorAll(".game-square");
  buttons.forEach((button) => {
    button.textContent = "";
    button.style.backgroundColor = "";
    button.style.color = "";
  });
}

/**
 * This function is used to handle the Click of the player
 * on the board
 */
function handleClick(event, button_text) {
  const winner = document.getElementById("winner");

  const button = document.getElementById(event.target.id);
  const player = document.getElementById("turn");
  var tmp = parseInt(event.target.id);
  //send to server and update the ui
  $.ajax({
    type: "POST",
    url: "api.php",
    data: { action: "play", index: tmp - 1 },
    success: function (response) {
      console.log("X Playing", response);
      //get the response (status, and comp_index)
      let gameState = response.response.status;

      //game needs to be started before clicking
      if (gameState == "Initial") {
        alert("You must click on start game or restart game first");
      } else if (gameState == "invalid") {
        //check that the square is empty before drawing
        console.log("invalid move");
        alert("You must click on an empty tile pick an other one");
      } else if (gameDone) {
        //cannot draw on the board until the game is reset
      } else {
        //styling the board
        let comp_index = response.response.comp_Index;
        let gamePlayer = response.response.player;
        let winIndex = response.response.Win_Index_ID;
        button.style.color = "red";
        button.textContent = "X";
        if (gameState == "win" && gamePlayer === "O") {
          computerPlay(comp_index, gameState); //to draw the last move made by the computer
          setWinnerColors(winIndex[0], winIndex[1], winIndex[2]);
          player.textContent = "Game is done";
          winner.textContent = "O WON, Please restart game to continue";
          updateLeaderboard();
          gameDone = true;
        } else if (gameState == "win" && gamePlayer === "X") {
          setWinnerColors(winIndex[0], winIndex[1], winIndex[2]);
          player.textContent = "Game is done";
          winner.textContent = "X WON, Please restart game to continue";
          gameDone = true;
          updateLeaderboard();
        } else if (gameState == "draw") {
          player.textContent = "Game is done";
          winner.textContent = "it is a draw, Please restart game to continue";
          setWinnerColors("0", "0", "0");
          gameDone = true;
        } else {
          player.textContent = "O turn";
          computerPlay(comp_index, gameState);
        }
      }
    },
    error: function (xhr, status, error) {
      console.log("Error server could not handle the click", error);
    },
  });
}

/**
 * When the computer plays
 *
 */
function computerPlay(index, gameState) {
  const square = document.getElementById(index + 1);
  square.textContent = "O";
  const player = document.getElementById("turn");

  //gameState is passed as a parameter from server
  if (gameState == "win" || gameState == "draw") {
    player.textContent = "Game is done";
  } else {
    player.textContent = "X turn";
  }
}

/**
 * function used to change the colors of the squares to green to show the winning pattern
 * it takes the three id squares and makes them green. if it is 0 0 0 then the
 * whole background becomes grey
 */

function setWinnerColors(id1, id2, id3) {
  if (id1 != "0") {
    const square1 = document.getElementById(id1);
    const square2 = document.getElementById(id2);
    const square3 = document.getElementById(id3);
    square1.style.backgroundColor = "green";
    square2.style.backgroundColor = "green";
    square3.style.backgroundColor = "green";
  }
  const buttons = document.querySelectorAll(".game-square");
  buttons.forEach((button) => {
    if (button.id != id1 && button.id != id2 && button.id != id3) {
      button.style.backgroundColor = "grey";
    }
  });
}

//event listners for clicks on our buttons/squares
document.addEventListener("DOMContentLoaded", (event) => {
  function performInitialAction() {
    $.ajax({
      type: "POST",
      url: "api.php",
      data: { action: "set_initial" },
      success: function (response) {
        console.log("Game state set to Initial", response);
        // Update the UI based on the initial state
        if (response.response.status === "Initial") {
          document.getElementById("turn").textContent =
            "Press 'Start' to begin";
          resetBoard();
        }
      },
      error: function (xhr, status, error) {
        console.log("Error setting game state to Initial", error);
      },
    });
  }

  // Call the initial action function when the DOM content is loaded
  performInitialAction();

  const buttons = document.querySelectorAll(".game-square");
  const start_btn = document.querySelector(".start-game");
  buttons.forEach((button) => {
    button.addEventListener("click", (event) => {
      const buttonText = button.textContent;
      handleClick(event, buttonText);
    });
  });

  start_btn.addEventListener("click", (event) => {
    handleStart(event);
  });
});
