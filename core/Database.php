<?php


namespace app\core;


class Database
{
    private \PDO $dbh;
    private \PDOStatement $stmt;
    private string $error;

    public function __construct($config)
    {
        $dsn = $config['dsn'];
        $user = $config['user'];
        $password = $config['password'];

        // set some connection options
        $options = [
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ];

        // create PDO instance
        try {
            // connect to db
            $this->dbh = new \PDO($dsn, $user, $password, $options);
        } catch (\PDOException $e) {
            // we catch error here
            $this->error = $e->getMessage();
            echo $this->error;
        }

        // create Users table if not exists
        $this->usersTableInit();
    }

    /**
     * Prepare statements for query
     * @param string $sql
     */
    public function query(string $sql)
    {
        // prepare sql statment and save it in local private var
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Check argument type and bind accordingly.
     *
     * use stm->bind(':email', 'john@jame.com');
     *
     * @param $param
     * @param $value
     * @param null $type
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            // check what type is $value
            switch (true) {
                case is_int($value):
                    $type = \PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = \PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = \PDO::PARAM_NULL;
                    break;
                default:
                    $type = \PDO::PARAM_STR;
            }
        }

        // Bind Value
        $this->stmt->bindValue($param, $value, $type);
    }


    /**
     * execute the saved statement.
     *
     * @return bool
     */
    public function execute()
    {
        return $this->stmt->execute();
    }

    /**
     *  Execute stmt. Get all results as an array of objects
     *
     * @return array
     */
    public function resultSet()
    {
        $this->execute();
        // PDO::FETCH_OBJ $result[1]->id
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Execute stmt. Get single result row as object
     * @return mixed
     */
    public function singleRow()
    {
        $this->execute();
        // PDO::FETCH_OBJ $result->id
        return $this->stmt->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * Get stmt affected or returned row count.
     *
     * @return int
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }


    /**
     * We check if there is no users table we create it
     *
     * Users tabe is need for authentication
     */
    private function usersTableInit()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS users 
       ( id INT NOT NULL AUTO_INCREMENT , 
       name VARCHAR(100) NOT NULL , 
       email VARCHAR(150) NOT NULL , 
       password VARCHAR(255) NOT NULL , 
       created_at TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
       PRIMARY KEY (id)) 
       ENGINE = InnoDB;
            ";
        $this->query($sql);
        $this->execute();
    }


}