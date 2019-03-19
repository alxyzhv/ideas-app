<?php

namespace app\models;

use PDO;

class Model
{
    /** @var PDO $db */
    static private $db;

    static protected $table;
    static protected $fillable;

    protected $id;
    protected $isSaved;

    public function __construct($data = [])
    {
        foreach (static::$fillable as $field) {
            if (array_key_exists($field, $data)) {
                $this->$field = $data[$field];
            }
        }
        $this->isSaved = false;
    }

    static function addConnection($config)
    {
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        $dns = "{$config['driver']}:dbname={$config['database']};host={$config['host']}";

        self::$db = new PDO($dns, $config['username'], $config['password'], $opt);
    }

    static function findAll()
    {
        $table = static::$table;
        $query = self::$db->query("select * from {$table}");
        $result = [];
        foreach ($query->fetchAll() as $row) {
            $item = new static($row);
            $item->isSaved = true;
            $result[] = $item;
        }
        return $result;
    }

    static function findOne($params)
    {
        $key = key($params);
        $value = current($params);
        $table = static::$table;
        $stmt = self::$db->prepare("select * from {$table} where $key = ? limit 1");
        $stmt->execute([
            $value
        ]);
        $row = $stmt->fetch();
        if ($row === false) {
            return null;
        }
        $result = new static($row);
        $result->isSaved = true;
        return $result;
    }

    static function find($params)
    {
        $key = key($params);
        $value = current($params);
        $table = static::$table;
        $stmt = self::$db->prepare("select * from {$table} where $key = ?");
        $stmt->execute([
            $value
        ]);
        $rows = $stmt->fetch();
        if (empty($row)) {
            return null;
        }
        $result = [];
        foreach ($rows as $row) {
            $item = new static($row);
            $item->isSaved = true;
            $result[] = $item;
        }
        return $result;
    }

    public function save()
    {
        $table = static::$table;

        $fields = $values = $newFields = [];
        if (empty($this->id) || !$this->isSaved) {
            foreach (static::$fillable as $field) {
                if ($field != "id") {
                    $values[] = $this->$field;
                    $fields[] = $field;
                    $newFields[] = "?";
                }
            }
            $fields = implode(',', $fields);
            $newFields = implode(',', $newFields);

            $stmt = self::$db->prepare("insert into {$table}($fields) values($newFields)");
            $stmt->execute($values);
            $this->isSaved = true;
            $this->id = self::$db->lastInsertId();
        } else {
            foreach (static::$fillable as $field) {
                if ($field != "id") {
                    $values[] = $this->$field;
                    $fields[] = $field . " = ?";
                }
            }
            $values[] = $this->id;
            $fields = implode(',', $fields);

            $stmt = self::$db->prepare("update {$table} set $fields where id = ?");
            $stmt->execute($values);
        }
    }

    public function delete()
    {
        if (!empty($this->id) && $this->isSaved) {
            $table = static::$table;
            $stmt = self::$db->prepare("delete from {$table} where id = ?");
            $stmt->execute([
                $this->id,
            ]);
            $this->isSaved = false;
        }
    }

    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return null;
    }

    protected function hasMany(Model $model, $link)
    {
        $key = key($link);
        $value = current($link);
        if (property_exists(get_class($this), $value)) {
            $params = [
                $key => $this->$value
            ];
            return $model::find($params);
        } else {
            return null;
        }
    }

    protected function hasOne(Model $model, $link)
    {
        $key = key($link);
        $value = current($link);
        if (property_exists(get_class($this), $value)) {
            $params = [
                $key => $this->$value
            ];
            return $model::findOne($params);
        } else {
            return null;
        }
    }

    public function getId()
    {
        return $this->id;
    }
}
