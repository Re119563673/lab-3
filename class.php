<?php

class CollatzAnalyzer {
    private $start;
    private $end;
    private $results = [];

    public function __construct($start, $end) {
        $this->start = $start;
        $this->end = $end;
        $this->calculate();
    }

    private function collatzSequence($n) {
        $iterations = 0;
        $max_value = $n;

        while ($n != 1) {
            if ($n % 2 == 0) {
                $n = $n / 2;
            } else {
                $n = 3 * $n + 1;
            }
            $max_value = max($max_value, $n);
            $iterations++;
        }

        return ['iterations' => $iterations, 'max' => $max_value];
    }

    private function calculate() {
        for ($i = $this->start; $i <= $this->end; $i++) {
            $this->results[$i] = $this->collatzSequence($i);
        }
    }

    public function getResults() {
        return $this->results;
    }

    public function getStatistics() {
        $max_iterations = ['number' => null, 'value' => 0];
        $min_iterations = ['number' => null, 'value' => PHP_INT_MAX];
        $max_reached_value = ['number' => null, 'value' => 0];

        foreach ($this->results as $num => $data) {
            if ($data['iterations'] > $max_iterations['value']) {
                $max_iterations = ['number' => $num, 'value' => $data['iterations']];
            }
            if ($data['iterations'] < $min_iterations['value']) {
                $min_iterations = ['number' => $num, 'value' => $data['iterations']];
            }
            if ($data['max'] > $max_reached_value['value']) {
                $max_reached_value = ['number' => $num, 'value' => $data['max']];
            }
        }

        return [
            'max_iterations' => $max_iterations,
            'min_iterations' => $min_iterations,
            'max_reached_value' => $max_reached_value
        ];
    }
}
?>
