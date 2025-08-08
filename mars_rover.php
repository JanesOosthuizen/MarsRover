<?php

class MarsRover {
	private $gridWidth;
    private $gridHeight;
    private $x;
    private $y;
    private $orientation;
    private $scents = [];
    private $isLost = false;
	private static $directions = ['N' => [0, 1], 'E' => [1, 0], 'S' => [0, -1], 'W' => [-1, 0]];
    private static $rightTurns = ['N' => 'E', 'E' => 'S', 'S' => 'W', 'W' => 'N'];
    private static $leftTurns = ['N' => 'W', 'W' => 'S', 'S' => 'E', 'E' => 'N'];

	public function __construct($gridWidth, $gridHeight) {
		$this->gridWidth = $gridWidth;
		$this->gridHeight = $gridHeight;
	}


}

function processMarsRoverInput(string $input): string {
	// Take inoput and split into lines
	$lines = array_filter(array_map('trim', explode("\n", $input)));
	$output = [];

	// get the grid size and dump first entry from array. The instantiate
	[$gridWidth, $gridHeight] = array_map('intval', explode(' ', array_shift($lines)));
	$rover = new MarsRover($gridWidth, $gridHeight);

	// Split the rest of the input. 
	for ($i = 0; $i < count($lines); $i += 2) {
		$position = $lines[$i];
		$instructions = $lines[$i + 1] ?? '';

		// Lets Go. 
		
	}

	return implode("\n", $output);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['input'])) {
    $input = $_POST['input'];
    $result = processMarsRoverInput($input);
    echo json_encode(['result' => $result]);
    exit;
}