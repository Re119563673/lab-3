<?php
require_once 'class.php';

class CollatzWebApp {
    private $start;
    private $end;

    public function __construct($start = null, $end = null) {
        $this->start = $start;
        $this->end = $end;
    }

    public static function render() {
        $start = $end = null;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $start = (int)$_POST['start'];
            $end = (int)$_POST['end'];
            $app = new self($start, $end);
            $app->displayResults();
        }

        echo '<!DOCTYPE html>
<html>
<head>
    <title>Collatz Conjecture Calculator</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 50%; margin: 20px 0; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        form { margin: 20px 0; }
        input[type="number"], input[type="submit"] { margin: 5px; padding: 5px; }
    </style>
</head>
<body>
    <h2>Collatz Conjecture Calculator</h2>
    <form method="post">
        <label>Start Number:</label> 
        <input type="number" name="start" required>
        <label>End Number:</label> 
        <input type="number" name="end" required>
        <input type="submit" value="Calculate">
    </form>';
    }

    private function displayResults() {
        $analyzer = new CollatzAnalyzer($this->start, $this->end);
        $results = $analyzer->getResults();
        $statistics = $analyzer->getStatistics();

        echo "<h3>Results:</h3>";
        echo '<table>';
        echo '<tr><th>Number</th><th>Max Value</th><th>Iterations</th></tr>';
        foreach ($results as $num => $data) {
            echo "<tr><td>$num</td><td>{$data['max']}</td><td>{$data['iterations']}</td></tr>";
        }
        echo '</table>';

        echo "<h3>Statistics:</h3>";
        echo '<table>';
        echo '<tr><th>Category</th><th>Number</th><th>Value</th></tr>';
        echo "<tr><td>Max Iterations</td><td>{$statistics['max_iterations']['number']}</td><td>{$statistics['max_iterations']['value']}</td></tr>";
        echo "<tr><td>Min Iterations</td><td>{$statistics['min_iterations']['number']}</td><td>{$statistics['min_iterations']['value']}</td></tr>";
        echo "<tr><td>Max Reached Value</td><td>{$statistics['max_reached_value']['number']}</td><td>{$statistics['max_reached_value']['value']}</td></tr>";
        echo '</table>';
    }
}

CollatzWebApp::render();
?>
