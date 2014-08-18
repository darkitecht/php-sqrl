<?php

class DB extends PDO
{
    /**
     * Parameterized Query
     *
     * @param string $statement
     * @param array $params
     * @param const $fetch_style
     * @return mixed -- array if SELECT
     */
    public function dbQuery($statement, $params = [], $fetch_style = PDO::FETCH_ASSOC)
    {
        $stmt = $this->prepare($statement);
        $exec = $stmt->execute($params);
        if ($exec) {
            return $stmt->fetchAll($fetch_style);
        }
        return false;
    }

    /**
     * Fetch a single result -- useful for SELECT COUNT() queries
     *
     * @param string $statement
     * @param array $params
     * @return mixed
     */
    public function single($statement, $params = [])
    {
        $stmt = $this->prepare($statement);
        $exec = $stmt->execute($params);
        if ($exec) {
            return $stmt->fetchColumn(0);
        }
        return false;
    }
}
