# MarsRover
Mars Rover Problem
Overview
This PHP program simulates robots moving on a rectangular grid on Mars based on instructions from Earth. It determines the final position and orientation of each robot, handling cases where robots may fall off the grid and leave a "scent" to prevent future robots from falling at the same point. A web interface allows users to input data, view results, and visualize each robot's path on a grid. Unit tests ensure the reliability of the core logic.
Features

Processes a rectangular grid with upper-right coordinates (e.g., 5,3) and lower-left at (0,0), resulting in a grid of size (6x4).
Supports robot instructions: Left (L), Right (R), Forward (F).
Tracks robot scents across all robots in a session to prevent repeated falls at the same grid point.
Extensible design for adding new command types in the future.
Validates input coordinates (max 50) and instruction length (max 100 characters).
Outputs final position, orientation, and "LOST" if a robot falls off the grid.
Web interface with Tailwind CSS for styling and JavaScript for async form submission and grid visualization.
Visualizes each robot's path on a canvas grid, with buttons to cycle through robots.
Unit tests using PHPUnit to verify core functionality.

Requirements

PHP 7.4 or higher
Web server (e.g., Apache, Nginx, or PHP's built-in server)
PHPUnit 9.x for running unit tests

Installation

Save mars_rover.php, index.html, and MarsRoverTest.php in a project directory (e.g., /path/to/MarsRover/).

Install PHPUnit (if not already installed):composer require --dev phpunit/phpunit ^9

To serve the application, use PHP's built-in server or a web server like Apache/Nginx.

Usage
Web Interface

Start a local PHP server:cd /path/to/MarsRover
php -S localhost:8000

Access http://localhost:8000/index.html in your web browser.
Note: Do not open index.html directly from the file system (e.g., file://), as this will cause CORS errors. Use the PHP server or a web server.


Enter input in the textarea in the format:gridWidth gridHeight
x y orientation
instructions
x y orientation
instructions
...

Example:5 3
1 1 E
RFRFRFRF
3 2 N
FRRFLLFFRRFLL
0 3 W
LLFFFLFLFL


Click "Run Simulation" to see the output and visualize the paths.

CLI Usage

Run the program via CLI for testing:php mars_rover.php

Provide input as shown above.

Running Unit Tests

Run PHPUnit tests from the project directory:vendor/bin/phpunit MarsRoverTest.php

Tests cover:
Robot staying in place with looping instructions
Robot getting lost off the grid
Robot changing orientation and moving
Scent preventing repeated falls
Invalid initial position handling
Empty instructions
Multi-robot input processing

Future Enhancements

Add new command types (e.g., backward movement) in the processCommand method.
Implement input validation for malformed inputs in both CLI and web interfaces.
Enhance visualization to show multiple robots simultaneously with different colors.
Add animation to show the robot moving step-by-step.
Add logging for debugging or telemetry purposes.
Expand unit tests to cover edge cases like malformed inputs.
