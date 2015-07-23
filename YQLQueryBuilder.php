<?php

class YQLQueryBuilder
{
    private $andWhere;
    private $orWhere;
    private $order;
    private $queryLimit;
    private $sqlQuery;
    private $remoteUrl;

    public function __construct()
    {
        $this->andWhere = array();
        $this->orWhere = array();
        $this->order = array();
        $this->remoteUrl = "https://query.yahooapis.com/v1/public/yql?q=";
    }

    /**
     * Begin query
     *
     * @param string $select Select
     * @param string $from From
     * @return self
     */
    public function beginQuery($select = "*", $from = "html")
    {
        $this->sqlQuery = "SELECT {$select} FROM {$from}";
        return $this;
    }

    /**
     * Where
     *
     * @param string $where Field name
     * @param string $value Value
     * @param mixed $operator Operator can be =, !=, >, <, IN, NOT IN, ...
     * @param string $delimiter AND or OR
     * @return self
     */
    public function where($where, $value, $operator = "=", $delimiter = "AND")
    {
        if (strtolower($operator) === "in" || strtolower($operator) === "not in") {
            if (is_array($value)) {
                $value = " ('" . implode("', '", $value) . "')";
            }
        } else {
            $value = "'" . $value . "'";
        }

        $this->{strtolower($delimiter) . "Where"}[] = "{$where} {$operator} {$value}";

        return $this;
    }

    /**
     * Limit
     *
     * @param int $limit Limit number of rows in the result set
     * @param int $offset First row returned by LIMIT
     * @return self
     */
    public function limit($limit, $offset = 0)
    {
        $queryLimit = "LIMIT {$limit} OFFSET {$offset}";

        return $this;
    }

    /**
     * Order
     *
     * @param string $expression The column that you wish to retrieve
     * @param string $direction
     */
    public function order($expression, $direction = "ASC")
    {

    }

    /**
     * Show query
     *
     * @return string Query command
     */
    public function showQuery()
    {
        $this->sqlQuery .= " WHERE ";

        if (count($this->andWhere) > 0) {
            $this->sqlQuery .= implode(" AND ", $this->andWhere);
        }

        if (count($this->orWhere) > 0) {
            $orQuery = " OR ";
            $this->sqlQuery .= $orQuery . implode(" OR ", $this->orWhere);
        }

        return $this->remoteUrl . urlencode($this->sqlQuery) . "&format=json";
    }
}
