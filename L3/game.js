var PUZZLE_SIZE_W = 4;
var PUZZLE_SIZE_H = 4;
const PUZZLE_RED_BLOCK_TINT = '#aaa222';
const PUZZLE_HOVER_TINT = '#a8a8a8';

var _stage;
var _canvas;

var _img;
var _pieces;
var _puzzleWidth;
var _puzzleHeight;
var _pieceWidth;
var _pieceHeight;
var _currentPiece;
var _currentDropPiece;  
var _idx = 0;

var _images;
var _small;
var _images_promise;

var _mouse;

function prepare() {
	_images = new Array(12);
	_small = new Array(12);
	_images_promise = new Array(12);
	for(var i = 0; i<12; i++) {
		_images_promise[i] = new Promise(function(resolve, reject) {
			_small[i] = new Image();
			_small[i].src = "img/small/" + i + ".jpg";
			_images[i] = new Image();
			_images[i].src = "img/big/" + i + ".jpg";

			if(_images[i]) {
				resolve(_images[i]);
			}
			else {
				reject(_small[i]);
			}
		});
		console.log(_images_promise[i]);
	}
}

function start(idx) {
	_idx = idx;
	restart();
}

function restart() {
	if(_canvas) gameOver()
	init();
}

function init() {
	console.log("init");
	_images_promise[_idx].then(function(img) {
		_img = img;
		PUZZLE_SIZE_W = parseInt(document.getElementById("width").value);
		PUZZLE_SIZE_H = parseInt(document.getElementById("height").value);
		_img.onload = onImage();
		console.log("-init");
	}).catch(function(img) {
		console.log("Nie udało się :c");
	})
}

function onImage(e) {
	console.log("onImage");
	_pieceWidth = Math.floor(_img.width / PUZZLE_SIZE_W)
	_pieceHeight = Math.floor(_img.height / PUZZLE_SIZE_H)
	_puzzleWidth = _pieceWidth * PUZZLE_SIZE_W;
	_puzzleHeight = _pieceHeight * PUZZLE_SIZE_H;
	setCanvas();
	initPuzzle();
	console.log("-onImage");
}

function setCanvas() {
	console.log("setCanvas");
	_canvas = document.getElementById('canvas');
	_stage = _canvas.getContext('2d');
	_canvas.width = _puzzleWidth;
	_canvas.height = _puzzleHeight;
	_canvas.style.border = "1px solid black";
	console.log("-setCanvas");
}

function initPuzzle() {
	console.log("initPuzzle");
	_pieces = [];
	_mouse = {x:0,y:0};
	_currentPiece = null;
	_currentDropPiece = null;
	_stage.drawImage(_img, 0, 0, _puzzleWidth, _puzzleHeight, 0, 0, _puzzleWidth, _puzzleHeight);
	buildPieces();
	console.log("-initPuzzle");
}

function buildPieces() {
	console.log("buildPieces");
	var i;
	var piece;
	var xPos = 0;
	var yPos = 0;
	for(i = 0; i < PUZZLE_SIZE_W * PUZZLE_SIZE_H; i++) {
		piece = {};
		piece.sx = xPos;
		piece.sy = yPos;
		piece.red = false;
		if(i == 0) {
			piece.red = true;
			_currentPiece = piece;
		}
		_pieces.push(piece);
		xPos += _pieceWidth;
		if(xPos >= _puzzleWidth) {
			xPos = 0;
			yPos += _pieceHeight;
		}
	}
	_canvas.onmousedown = shufflePuzzle;
	console.log("-buildPieces");
}

function shufflePuzzle() {
	console.log("shufflePuzzle");
	_pieces = shuffleArray(_pieces);
	_stage.clearRect(0, 0, _puzzleWidth, _puzzleHeight);
	var i;
	var piece;
	var xPos = 0;
	var yPos = 0;
	for(i = 0;i < _pieces.length;i++) {
		piece = _pieces[i];
		piece.xPos = xPos;
		piece.yPos = yPos;
		drawPiece(piece)
		_stage.strokeRect(xPos, yPos, _pieceWidth,_pieceHeight);
		xPos += _pieceWidth;
		if(xPos >= _puzzleWidth) {
			xPos = 0;
			yPos += _pieceHeight;
		}
	}
	_canvas.onmousemove = updatePuzzle;
	_canvas.onmousedown = pieceDropped;
	console.log("-shufflePuzzle");
}

function updatePuzzle(e) {
	console.log("updatePuzzle");
	_currentDropPiece = null;
	var rect = _canvas.getBoundingClientRect();
	_mouse.x = e.clientX - rect.left;
	_mouse.y = e.clientY - rect.top;
	_stage.clearRect(0,0,_puzzleWidth,_puzzleHeight);
	var i;
	var piece;
	for(i = 0;i < _pieces.length;i++) {
		piece = _pieces[i];
		drawPiece(piece)
		_stage.strokeRect(piece.xPos, piece.yPos, _pieceWidth,_pieceHeight);
		if(_currentDropPiece == null) {
			if(_mouse.x / rect.width > piece.xPos / _img.width
			&& _mouse.x / rect.width < (piece.xPos + _pieceWidth) / _img.width
			&& _mouse.y / rect.height > piece.yPos / _img.height
			&& _mouse.y / rect.height < (piece.yPos + _pieceHeight) / _img.height
			&& pieceLegal(piece)) {
				_currentDropPiece = piece;
				_stage.save();
				_stage.globalAlpha = .4;
				_stage.fillStyle = PUZZLE_HOVER_TINT;
				_stage.fillRect(_currentDropPiece.xPos, _currentDropPiece.yPos, _pieceWidth, _pieceHeight);
				_stage.restore();
			}
		}
	}
	console.log("-updatePuzzle");
}

function pieceLegal(piece) {
	var onLeft = Math.abs((piece.xPos - _currentPiece.xPos) / _pieceWidth);
	var above = Math.abs((piece.yPos - _currentPiece.yPos) / _pieceHeight);
	return (onLeft + above) == 1;
}

function pieceDropped(e) {
	console.log("pieceDropped");
	if(_currentDropPiece != null && pieceLegal(_currentDropPiece)) {
		var tmp = {xPos:_currentPiece.xPos,yPos:_currentPiece.yPos};
		_currentPiece.xPos = _currentDropPiece.xPos;
		_currentPiece.yPos = _currentDropPiece.yPos;
		_currentDropPiece.xPos = tmp.xPos;
		_currentDropPiece.yPos = tmp.yPos;
	}
	resetPuzzleAndCheckWin();
	console.log("-pieceDropped");
}

function resetPuzzleAndCheckWin() {
	console.log("resetPuzzleAndCheckWin");
	_stage.clearRect(0, 0, _puzzleWidth, _puzzleHeight);
	var gameWin = true;
	var i;
	var piece;
	for(i = 0;i < _pieces.length;i++) {
		piece = _pieces[i];
		drawPiece(piece)
		_stage.strokeRect(piece.xPos, piece.yPos, _pieceWidth,_pieceHeight);
		if(piece.xPos != piece.sx || piece.yPos != piece.sy) {
			gameWin = false;
		}
	}
	if(gameWin) {
		setTimeout(gameOver,500);
	}
	console.log("-resetPuzzleAndCheckWin");
}

function gameOver() {
	console.log("gameOver");
	_canvas.onmousedown = null;
	_canvas.onmousemove = null;
	_canvas.onmouseup = null;
	initPuzzle();
	console.log("-gameOver");
}

function shuffleArray(o) {
	console.log("shuffleArray");
	r = 0;
	t = null;
	var steps =  ~~(Math.random() * 20) + 10;
	for(var i = 0; i < steps; i++) {
		t = o[r];
		switch(~~(Math.random() * 4)) {
			case 0: // left
				if((r % PUZZLE_SIZE_W) > 0) {
					o[r] = o[r-1];
					o[r-1] = t;
					r--;
					console.log(r, "left");
				}
				else i--;
				break;
			case 1: // right
				if((r % PUZZLE_SIZE_W) < PUZZLE_SIZE_W-1) {
					o[r] = o[r+1];
					o[r+1] = t;
					r++;
					console.log(r, "right");
				}
				else i--;
				break;
			case 2: // up
				if(~~(r / PUZZLE_SIZE_W) > 0) {
					o[r] = o[r-PUZZLE_SIZE_W];
					o[r-PUZZLE_SIZE_W] = t;
					r -= PUZZLE_SIZE_W;
					console.log(r, "up");
				}
				else i--;
				break;
			case 3: // down
				if(~~(r / PUZZLE_SIZE_W) < PUZZLE_SIZE_H-1) {
					o[r] = o[r+PUZZLE_SIZE_W];
					o[r+PUZZLE_SIZE_W] = t;
					r += PUZZLE_SIZE_W;
					console.log(r, "down");
				}
				else i--;
				break;
		}
	}
	console.log("-shuffleArray");
	return o;
}

function drawPiece(piece) {
	if(piece.red) {
		_stage.save();
		_stage.globalAlpha = .4;
		_stage.fillStyle = PUZZLE_RED_BLOCK_TINT;
		_stage.fillRect(piece.xPos, piece.yPos, _pieceWidth, _pieceHeight);
		_stage.drawImage(_img, piece.sx, piece.sy, _pieceWidth, _pieceHeight, piece.xPos, piece.yPos, _pieceWidth, _pieceHeight);
	}
	else _stage.drawImage(_img, piece.sx, piece.sy, _pieceWidth, _pieceHeight, piece.xPos, piece.yPos, _pieceWidth, _pieceHeight);
	_stage.restore();
}