const _data = {
	gameOn: false,
	timeout: undefined,
	sounds: [],

	strict: false,
	playerCanPlay: false,
	score: 0,
	gameSequence: [0,1,2,3,4,5],
	playerSequence: []
};

const _gui = {
	counter: document.querySelector(".gui__counter"),
	switch: document.querySelector(".gui__btn-switch"),
	led: document.querySelector(".gui__led"),
	strict: document.querySelector(".gui__btn--strict"),
	start: document.querySelector(".gui__btn--start"),
	pads: document.querySelectorAll(".game__pad")
}

const _soundUrls = [
	"audio/C.wav",
	"audio/D.wav",
	"audio/E.wav",
	"audio/F.wav",
	"audio/G.wav",
	"audio/A.wav"
];

_soundUrls.forEach(sndPath => {
	const audio = new Audio(sndPath);
	_data.sounds.push(audio);
});

_gui.switch.addEventListener("click", () => {
	_data.gameOn = _gui.switch.classList.toggle("gui__btn-switch--on");

	_gui.counter.classList.toggle("gui__counter--on");
	_gui.counter.innerHTML = "--";

	_data.strict = false;
	_data.playerCanPlay = false;
	_data.score = 0;
	_data.gameSequence = [0,1,2,3,3,3];
	_data.gameSequence2 = [0,1,0,1,1,1];
	_data.gameSequence3 = [0,4,3,2,2,2];
	_data.gameSequence4 = [0,1,2,3,3,3];
	_data.playerSequence = [];

	disablePads();

	_gui.led.classList.remove("gui__led--active");

});

 _gui.strict.addEventListener("click", () => {
 	if(!_data.gameOn)
 		return;
 	_data.strict = _gui.led.classList.toggle("gui__led--active");


 });

_gui.start.addEventListener("click", () => {
	startGame();

});

const padListener = (e) => {
	if(!_data.playerCanPlay)
		return;

	let soundId;
	_gui.pads.forEach((pad, key) => {
		if(pad === e.target)
			soundId = key;
	});

	e.target.classList.add("game__pad--active");


	_data.sounds[soundId].play();
	_data.playerSequence.push(soundId);

	setTimeout(()=>{
		e.target.classList.remove("game__pad--active");

		const currentMove = _data.playerSequence.length -1;
	
		if(_data.playerSequence[currentMove] !== _data.gameSequence[currentMove]){
			_data.playerCanPlay = false;
			disablePads();
			resetOrPlayAgain();
	
		}
		else if (currentMove === _data.gameSequence.length -1){
			
            			
			newColor();
			playSequence();
			
		}
	
		waitForPlayerClick();

	}, 200);
}


_gui.pads.forEach(pad => {
	pad.addEventListener("click", padListener);
});

const startGame = () => {
	blink("--", () => {
//		newColor();
		
		playSequence();
	})
}

const setScore = () => {
	const score = _data.score.toString();
	const display = "00".substring(0, 2 - score.length) + score;
	_gui.counter.innerHTML = display;
}

const newColor = () => {
	if(_data.score === 20){
		blink("**", startGame);
		return;
	}
	
	_data.gameSequence = _data.gameSequence2;
	_data.score++;
	console.log(_data.score);
	if(_data.score == 2){
	    	_data.gameSequence = _data.gameSequence3;
	        
	}
	if(_data.score == 3){
	    	_data.gameSequence = _data.gameSequence4;
	       
		}
		

		

	setScore();
	
	if (_data.score == 4){
	    alert("PARABÉNS, VOCÊ VENCEU!");
	    
	    _data.gameOn = false;
		
	}
}

const playSequence = () => {
	let counter = 0,
		padOn = true;

	_data.playerSequence = [];
	_data.playerCanPlay = false;

	const interval = setInterval(() => {
		if(!_data.gameOn){
			clearInterval(interval);
			disablePads();
			return;
		}
		
		if(padOn){
			if(counter === _data.gameSequence.length){
				clearInterval(interval);
				disablePads();
				waitForPlayerClick();
				_data.playerCanPlay = true;
				return;
			}
			const sndId = _data.gameSequence[counter];
			const pad = _gui.pads[sndId];
			
			_data.sounds[sndId].play();
			pad.classList.add("game__pad--active");
			counter++;
		}
		else {
			disablePads();
		}

		padOn = !padOn;
	}, 300);
}

const blink = (text, callback) => {
	let counter = 0,
		on = true;
	
	_gui.counter.innerHTML = text;

	const interval = setInterval(() => {
		if(on) { 
			_gui.counter.classList.remove("gui__counter--on");
		}
		else{
			_gui.counter.classList.add("gui__counter--on");

			if(++counter === 3){
				clearInterval(interval);
				callback();
			}
		}

		on = !on;

	}, 250);

}

const waitForPlayerClick = () => {
	clearTimeout(_data.timeout);
	_data.timeout = setTimeout(() => {
		if(!_data.playerCanPlay)
			return;

		disablePads();
		resetOrPlayAgain();
	}, 5000);

}

const resetOrPlayAgain = () => {
	_data.playerCanPlay = false;

	if(_data.strict){
		blink("!!", () =>{
			_data.score = 0;
			_data.gameSequence = [];
			startGame();
		});
	}
	else {
		blink("!!,", () => {
			setScore();
			playSequence();
		});
	}

}

const changePadCursor = (cursorType) => {

}

const disablePads = () => {
	_gui.pads.forEach(pad => {
		pad.classList.remove("game__pad--active");
	})
}