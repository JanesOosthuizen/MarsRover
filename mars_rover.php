<?php

class MarsRover {
	private $gridWidth;
    private $gridHeight;
    private $x;
    private $y;
    private $orientation;
    private $scents = [];
    private $isLost = false;
	// We have the initial orientation. When we move we need to update the orientation to a new one. 

	public function __construct($gridWidth, $gridHeight) {
		$this->gridWidth = $gridWidth;
		$this->gridHeight = $gridHeight;
	}

	public function execute(string $startPosition, string $instructions): string {
		[$x, $y, $orientation] = explode(' ', $startPosition);

		// Set Start Positions and Orientation
 		$this->x = (int)$x;
        $this->y = (int)$y;
        $this->orientation = $orientation; // But what would orientation look like.. 

		// Not Lost yet. 
        $this->isLost = false;

		// Start position
		// To see  if robot has fallen. x < than 0 or x > than gridWidth or y < than 0 or y > than gridHeight
		// Will use this again later.
        if ($this->x < 0 || $this->x > $this->gridWidth || $this->y < 0 || $this->y > $this->gridHeight) {
            return "$this->x $this->y $this->orientation LOST";
        }

		$output = "$this->x $this->y $this->orientation";
        return $this->isLost ? "$output LOST" : $output;
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
		$output[] =$rover->execute($position, $instructions);
	}

	return implode("\n", $output);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['input'])) {
    $input = $_POST['input'];
    $result = processMarsRoverInput($input);
    echo json_encode(['result' => $result]);
    exit;
}