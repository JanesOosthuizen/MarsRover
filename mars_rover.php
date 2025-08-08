<?php

class MarsRover {
	private $gridWidth;
    private $gridHeight;
    private $x;
    private $y;
    private $orientation;
    private $scents = [];
    private $isLost = false;
	private static $rightTurns = ['N' => 'E', 'E' => 'S', 'S' => 'W', 'W' => 'N'];
    private static $leftTurns = ['N' => 'W', 'W' => 'S', 'S' => 'E', 'E' => 'N'];

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

		//Take the direction and split them into an array.
		$directions = str_split($instructions);

		// Follow Directions
		foreach($directions as $direction) {
			//If rover is lost. stop
			if ($this->isLost) break;

			// Time to move the Rover
			// Need a function to check each move. update x and y and change direction
			$this->moveRover($direction);
		}

		$output = "$this->x $this->y $this->orientation";
        return $this->isLost ? "$output LOST" : $output;
	}

	private function moveRover(string $command): void {
		// If Left then orientation will turn clockwise so. If orientation is N then it will be W.  if S and move R it will be W. , Forward will stay Forward. X & Y will only update with forward
		// Can create and array { 'N' => 'W', 'W' => 'S', 'S' => 'E', 'E' => 'N' } 
		switch ($command) {
            case 'L':
                $this->orientation = self::$leftTurns[$this->orientation];
                break;
            case 'R':
                $this->orientation = self::$rightTurns[$this->orientation];
                break;
            case 'F':
				$this->moveForward();
                break;
        }
	}

	private function moveForward(): void {

		$newX = 0;
		$newY = 0;

		// So moving foreward will update the x and y. Each diretion will update a specific axis by 1. so North.. Y +1 and South Y -1. etc.
		switch ($this->orientation) {
			case 'N':
				$newY = $this->y++;
				$newX = $this->x;
				break;
			case 'E':
				$newX = $this->x++;
				$newY = $this->y;
				break;
			case 'S':
				$newY = $this->y--;
				$newX = $this->x;
				break;
			case 'W':
				$newX = $this->x--;
				$newY = $this->y;
				break;
		}

		// Check if Rover has fallen and also check for cents Copy Past above. 
		if ($newX < 0 || $newX > $this->gridWidth || $newY < 0 || $newY > $this->gridHeight) {
            // Add the Scents Checks
			if(!in_array("$this->x,$this->y", $this->scents)) {
				$this->scents[] = "$this->x,$this->y";
				$this->isLost = true;
			}
			return;
        }

		// didnt fall update the new coords. 
		$this->x = $newX;
		$this->y = $newY;
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
		$output[] = $rover->execute($position, $instructions);
	}

	return implode("\n", $output);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['input'])) {
    $input = $_POST['input'];
    $result = processMarsRoverInput($input);
    echo json_encode(['result' => $result]);
    exit;
}