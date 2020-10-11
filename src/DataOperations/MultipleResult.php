<?php
namespace InteractivePlus\PDK2021Base\DataOperations;
class MultipleResult{
    private int $numResults;
    private ?array $results;
    
    /**
     * @template T
     * @param int $numResults number of results searched, 0 if not found
     * @param ?array<T> $resultArray the array containing all matching results
     */
    public function __construct(int $numResults, ?array $resultArray){
        $this->numResults = $numResults;
        $this->results = $resultArray;
    }

    /**
     * get the number of results matching
     * @return int number of results, 0 if not found
     */
    public function getNumResults() : int{
        return $this->numResults;
    }

    /**
     * get the array containing all matching results
     * @return ?array array of results
     */
    public function getResultArray() : ?array{
        return $this->results;
    }
}