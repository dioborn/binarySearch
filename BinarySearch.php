<?php

class BinarySearch {

    protected $recSeparator = "\x0A";
    protected $keySeparator = "\t";
    protected $iterations = 0;
    protected $debug = false;

    public function __construct($options = array()) {
        if (isset($options['keySeparator'])) {
            $this->$keySeparator = $options['keySeparator'];
        }
        if (isset($options['recSeparator'])) {
            $this->$recSeparator = $options['recSeparator'];
        }
    }

    public function run($fileName, $key) {

        if (!file_exists($fileName)) {
            echo "\nNotice: incorrect filename, file doesn't exist!\n";
            return;
        }

        if (!$file = fopen($fileName, "r")) {
            echo "\nNotice: can't open file " . $fileName . " for read!\n";
            return;
        }

        $fileSize = filesize($fileName);

        return $this->findInRange($file, $key, 0, $fileSize);
    }

    public function findInRange($file, $key, $leftBorder, $rightBorder) {
        while ($leftBorder < $rightBorder) {
            $this->iterations++;
            $offset = $leftBorder + floor(($rightBorder - $leftBorder) / 2);
            $offsetKey = $this->getKeyByOffset($file, $offset);
            if ($this->debug) {
                echo "\n\nIteration: " . $this->iterations . "\n";
                echo "leftBorder: " . $leftBorder . "\n";
                echo "rightBorder: " . $rightBorder . "\n";
                echo "offset: " . $offset . "\n";
                echo "offsetKey: " . $offsetKey . "\n";
            }

            if (!$offsetKey) {
                return;
            }
            if ($offsetKey == $key) {
                return $this->getValueByOffset($file, $offset + strlen($key));
            }

            if ($offsetKey > $key) {
                $rightBorder = $offset;
            } else {
                $leftBorder = $offset + 1;
            }
        }

        return;
    }

    protected function getKeyByOffset($file, $offset) {
        return $this->getStringBetweenChars($file, $offset, $this->recSeparator, $this->keySeparator);
    }

    protected function getValueByOffset($file, $offset) {
        return $this->getStringBetweenChars($file, $offset, $this->keySeparator, $this->recSeparator);
    }

    protected function getStringBetweenChars($file, $offset, $firstChar, $secondChar) {
        fseek($file, $offset);
        while ($offset && ($char = fgetc($file)) !== false && $char != $firstChar) {
            $offset--;
            fseek($file, $offset);
        }

        $value = '';
        while (($char = fgetc($file)) !== false && $char != $secondChar) {
            $value .= $char;
        }

        return $value;
    }

    public function getIterations() {
        return $this->iterations;
    }
    
    public function setDebug($debug) {
        $this->debug = !empty($debug) ? true : false;
    }

}
