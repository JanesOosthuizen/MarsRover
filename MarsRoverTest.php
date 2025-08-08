<?php

use PHPUnit\Framework\TestCase;

require_once 'mars_rover.php';

class MarsRoverTest extends TestCase {
    private $rover;

    protected function setUp(): void {
        // Grid size 5,3 becomes 6x4 to include (0,0)
        $this->rover = new MarsRover(5, 3);
        MarsRover::resetScents(); // Clear scents before each test
    }

    public function testRobotStaysInPlaceWithLoopingInstructions(): void {
        $result = $this->rover->execute("1 1 E", "RFRFRFRF");
        $this->assertEquals("1 1 E", $result);
    }

    public function testRobotMovesAndGetsLost(): void {
        $result = $this->rover->execute("3 2 N", "FRRFLLFFRRFLL");
        $this->assertEquals("3 3 N LOST", $result);
    }

    public function testRobotChangesOrientationAndMoves(): void {
        $result = $this->rover->execute("0 3 W", "LLFFFLFLFL");
        $this->assertEquals("3 3 N LOST", $result);
    }

	public function testRobotIgnoresMoveOffGridDueToScent(): void {
        $this->rover->execute("3 2 N", "FF");
        $result = $this->rover->execute("3 2 N", "FF");
        $this->assertEquals("3 3 N", $result);
    }

    public function testInvalidInitialPositionMarksAsLost(): void {
        $result = $this->rover->execute("6 1 E", "F");
        $this->assertEquals("6 1 E LOST", $result);
    }

    public function testEmptyInstructionsKeepsInitialPosition(): void {
        $result = $this->rover->execute("2 2 N", "");
        $this->assertEquals("2 2 N", $result);
    }

    public function testProcessInputHandlesMultipleRobots(): void {
        $input = "5 3\n1 1 E\nRFRFRFRF\n3 2 N\nFRRFLLFFRRFLL\n0 3 W\nLLFFFLFLFL";
        $expected = "1 1 E\n3 3 N LOST\n2 3 S";
        $result = processMarsRoverInput($input);
        $this->assertEquals($expected, $result);
    }

}

?>