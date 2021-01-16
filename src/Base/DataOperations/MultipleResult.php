<?php
namespace InteractivePlus\PDK2021Core\Base\DataOperations;
class MultipleResult{
    private int $numResultsStored;
    private ?array $results;
    private int $numTotalQueryResults;
    private int $dataOffset;

    /**
     * @template T
     * @param int $numResultsStored number of results searched, 0 if not found
     * @param ?array<T> $resultArray the array containing all matching results
     * @param int $numTotalQueryResults the total number of results in database, can be -1(unknown)
     * @param int $dataOffset the offset(from database) that the result stored is at
     */
    public function __construct(int $numResultsStored, ?array $resultArray, int $numTotalQueryResults, int $dataOffset){
        $this->numResults = $numResultsStored;
        $this->results = $resultArray;
        $this->numTotalQueryResults = $numTotalQueryResults;
        $this->dataOffset = $dataOffset;
    }

    /**
     * get the number of results stored, or count of result array
     * @return int number of results stored (count of result array), 0 if not found
     */
    public function getNumResultsStored() : int{
        return $this->numResults;
    }

    /**
     * get the array containing all matching results
     * @return ?array array of results
     */
    public function getResultArray() : ?array{
        return $this->results;
    }

    /**
     * get the number of total results that conforms to the search constraints
     * @return int num of total results, -1 means unknown
     */
    public function getNumTotalQueryResults() : int{
        return $this->numTotalQueryResults;
    }

    /**
     * get the offset of the result stored
     * @return int offset of the stored data
     */
    public function getDataOffset() : int{
        return $this->dataOffset;
    }
}