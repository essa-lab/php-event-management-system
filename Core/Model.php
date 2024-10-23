<?php
namespace Core;
use Core\App;
use Core\Database;

class Model
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    protected $attributes = [];
    protected $selectColumns = '*';

    protected $whereClauses = [];
    protected $orWhereClauses = [];
    protected $joinClauses= [];

    protected $bindings = [];
    
    protected $groupByClauses=[];
    protected $perPage = 10;

    // construct the model by providing a database connection.
    public function __construct($data = [])
    {
        $this->db = App::resolve(Database::class);
        $this->attributes = $data;
    }

        // get all records with optional conditions
        public static function all()
        {
            $instance = new static();
            $sql = "SELECT {$instance->selectColumns} FROM {$instance->table}";

            if (!empty($instance->whereClauses)) {
                $sql .= ' WHERE ' . implode(' AND ', $instance->whereClauses);
            }
            
            return $instance->db->query($sql, $instance->bindings);
        }

    // find a record by its primary key
    public function find($id)
    {
        return $this->where($this->primaryKey, $id)->first();
    }

    // add select columns to the query
    public function select($columns = '*')
    {
        $this->selectColumns = is_array($columns) ? implode(', ', $columns) : $columns;
        return $this; // enables chaining
    }
    // add a where clause to the query
    public function where($column, $operator, $value = null)
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $this->whereClauses[] = "{$column} {$operator} ?";
        $this->bindings[] = $value;

        return $this; // Enables chaining
    }

    // add or where clause to the query
    public function orWhere($column, $operator, $value = null)
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $this->orWhereClauses[] = "{$column} {$operator} ?";
        $this->bindings[] = $value;

        return $this; // enables chaining
    }
    // add joins to the query
    public function join($table, $first, $operator, $second)
    {
        $this->joinClauses[] = "JOIN {$table} ON {$first} {$operator} {$second}";
        return $this; // enables chaining
    }

    //add group by to the query
    public function groupBy($columns)
    {
        if (is_array($columns)) {
            $this->groupByClauses = array_merge($this->groupByClauses, $columns);
        } else {
            $this->groupByClauses[] = $columns;
        }
        return $this; // Enable chaining
    }

    // Get the first matching result
    public function first()
    {
        // $sql = "SELECT * FROM {$this->table}";

        $sql = "SELECT {$this->selectColumns} FROM {$this->table}";

        if (!empty($this->whereClauses)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->whereClauses);
        }

        if (!empty($this->orWhereClauses)) {
            $sql .= ' WHERE ' . implode(' OR ', $this->orWhereClauses);
        }
        if (!empty($instance->joinClauses)) {
            $sql .= ' ' . implode(' ', $this->joinClauses);
        }

        $result=$this->db->query($sql, $this->bindings, true);
        if ($result) {
            $this->attributes = $result; 
            return $this;
        }
    
        return null;
    }

    // Paginate results
    public function paginate($perPage = null, $page = 1)
    {
        $this->perPage = $perPage ?: $this->perPage; 
        $offset = ($page - 1) * $this->perPage; 

        // $sql = "SELECT * FROM {$this->table}";
        $sql = "SELECT {$this->selectColumns} FROM {$this->table}";

        // add join , where , or where ,group by to the query if exists.
        if (!empty($this->joinClauses)) {
            $sql .= ' ' . implode(' ', $this->joinClauses);
        }
        if (!empty($this->whereClauses)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->whereClauses);
        }
        if (!empty($this->orWhereClauses)) {
            $sql .= ' WHERE ' . implode(' OR ', $this->orWhereClauses);
        }
        if (!empty($this->groupByClauses)) {
            $sql .= ' GROUP BY ' . implode(', ', $this->groupByClauses);
        }

        
        // count total records for pagination
        $totalRecordsSql = str_replace('SELECT *', 'SELECT COUNT(*) as total', $sql);
        $totalRecordsResult = $this->db->query($totalRecordsSql, $this->bindings, true);
        $totalRecords = $totalRecordsResult['total'];

        // add limit and offset for pagination
        $sql .= " LIMIT {$this->perPage} OFFSET {$offset}";
        
        $results = $this->db->query($sql, $this->bindings);

        return [
            'data' => $results,
            'current_page' => $page,
            'per_page' => $this->perPage,
            'total_records' => $totalRecords,
            'total_pages' => ceil($totalRecords / $this->perPage)
        ];
    }


   

    // save the current model instance (insert or update)
    public function save()
    {
        if (isset($this->attributes[$this->primaryKey])) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    // delete the current model instance
    public function delete()
    {
        if (isset($this->attributes[$this->primaryKey])) {
            $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
            $this->db->query($sql, [$this->attributes[$this->primaryKey]]);
            return true;
        }
        return false;
    }

    // insert a new record
    protected function insert()
    {
        $columns = implode(', ', array_keys($this->attributes));
        $placeholders = implode(', ', array_fill(0, count($this->attributes), '?'));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";

        $this->db->query($sql, array_values($this->attributes));
        $this->attributes[$this->primaryKey] = $this->db->lastInsertId();
    }

    // update an existing record
    protected function update()
    {
        $columns = array_keys($this->attributes);
        $setString = implode(' = ?, ', $columns) . ' = ?';
        $sql = "UPDATE {$this->table} SET {$setString} WHERE {$this->primaryKey} = ?";
        $this->db->query($sql, array_merge(array_values($this->attributes), [$this->attributes[$this->primaryKey]]));
    }

    // set attributes for an record ( object)
    public function setAttributes(array $attr){
        // dd($this->attributes);

        $this->attributes = $attr;
    }

    // get attributes for an record ( object)
    public function get(){
        return $this->attributes;
    }
}
