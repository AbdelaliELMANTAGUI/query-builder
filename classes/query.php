<?php
class Query
{
    private $con = null;
    public $finalQuery = null;
    private $operation = null;
    private $operationParams = null;
    private $fromClause = null;
    private $intoClause = null;
    private $whereClause = null;
    private $updateTable = null;
    private $limitClause = null;
    function __construct($con){
        $this->con = $con;
    }
    // private 
    public function select()
    {
        $this->operationParams = array();
        if (func_num_args() > 0) {
            array_push($this->operationParams, ...func_get_args());
        }
        $this->operation = QueryOperations::select;
        return $this;
    }
    private function isAssoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
    function insert($values)
    {
        if (!$this->isAssoc($values)) throw new Error("You must pass an assoc array");
        $this->operation = QueryOperations::insert;
        $this->operationParams = $this->concateValues($values);
        return $this;
    }
    public function update($model)
    {
        $this->operation = QueryOperations::update;
        $this->updateTable = $model->getTableName();
        return $this;
    }
    public function delete()
    {
        $this->operation = QueryOperations::delete;
        return $this;
    }
    public function set($values)
    {
        if (!$this->isAssoc($values)) throw new Error("You must pass an assoc array");
        $this->operationParams = $this->concateValues($values);
        return $this;
    }
    public function from($model)
    {
        $this->fromClause = $model->getTableName();
        return $this;
    }
    public function into($model)
    {
        $this->intoClause = $model->getTableName();
        return $this;
    }
    public function where($condition)
    {
        $this->whereClause = $condition;
        return $this;
    }
    public function limit($n=1)
    {
        $this->limitClause = $n;
        return $this;
    }
    private function concateValues($values)
    {
        if (!$this->isAssoc($values)) throw new Error("You must pass an assoc array");
        foreach ($values as $index => $value) {
            if (is_string($value)) {
                $values[$index] = "'" . $value . "'";
            }
            if (is_bool($value)) {
                $values[$index] = $value ? "TRUE" : "FALSE";
            }
        }
        return $values;
    }
    private function concateKeys($keys){
        foreach($keys as $index=>$key){
            $keys[$index] = "`$key`";
        }
        return $keys;
    }
    function build()
    {
        switch ($this->operation) {
            case QueryOperations::select:
                $this->finalQuery = QueryOperations::select . " " . ($this->operationParams ? join(",", $this->operationParams) : "*") . " FROM `$this->fromClause` " . ($this->whereClause ? "WHERE $this->whereClause" : "");
                break;
            case QueryOperations::insert:
                $this->finalQuery = QueryOperations::insert . " INTO `$this->intoClause` (" . join(",", $this->concateKeys(array_keys($this->operationParams))) . ") VALUES (" . join(",", array_values($this->operationParams)) . ") ";
                break;
            case QueryOperations::update:
                $this->finalQuery = QueryOperations::update . " `$this->updateTable` SET ";
                $sets = array();
                foreach ($this->operationParams as $key => $value) {
                    array_push($sets, "`$key`=" . (is_string($value)?"'$value'":$value) );
                }
                $this->finalQuery .= join(",", $sets);
                $this->finalQuery .= $this->whereClause ? " WHERE $this->whereClause" : "";
                break;
            case QueryOperations::delete:
                $this->finalQuery = QueryOperations::delete . " `$this->fromClause` ".($this->whereClause ? " WHERE $this->whereClause" : "");
                break;
        }
        $this->finalQuery .= $this->limitClause?" LIMIT $this->limitClause ":"";
        return $this->finalQuery;
    }

    public function prepare(){
        if($this->con == null ) throw new Error('Connection insrance is null');
        return new ORM($this->con,$this->con->prepare($this->build()));
    }
}