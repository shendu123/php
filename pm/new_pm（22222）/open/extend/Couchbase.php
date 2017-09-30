<?php
class Couchbase
{
	public $bucket;
	public $bucketName;
    public $error = ''; 
    private static $_cluster = null; 
    protected $_sql = array(); 

	public function __construct($config)
	{
		try {
			if (is_null ( self::$_cluster )) {
				self::$_cluster = new CouchbaseCluster("couchbase://{$config['host']}");
			}

			$this->bucketName = $config['bucket'];
			$this->bucket = self::$_cluster->openBucket($config['bucket']);
		}
		catch (Exception $e)
		{
			$this->error = $e->getMessage();          
		}
	}

	public function where($where)
	{
		$this->_sql['where'] = $where;
		return $this;
	}

	public function order($order)
	{
		$this->_sql['order'] = $order;
		return $this;
	}

	public function limit($limit)
	{
		$this->_sql['limit'] = $limit;
		return $this;
	}

	public function offset($offset)
	{
		$this->_sql['offset'] = $offset;
		return $this;
	}

	public function use_keys($key=array())
	{
		$key = json_encode($key);
		$this->_sql['use_keys'] = $key;
		return $this;
	}


	public function field($field)
	{
		$this->_sql['field'] = $field;
		return $this;
	}

	public function bucket($bucket)
	{
		$this->_sql['bucket'] = $bucket;
		return $this;
	}

	public function select()
	{
		if(empty($this->_sql['bucket']))
		{
			$bucket = $this->bucketName;
		}
		else
		{
			$bucket= $this->_sql['bucket'];
		}

		if(empty($this->_sql['field']))
		{
			$field = '*';
		}
		else
		{
			$field= $this->_sql['field'];
		}

        if(!empty($this->_sql['where']))
        {
            $where = 'where '.$this->_sql['where'];
        }
        else
        {
            $where ='';
        }

		if(!empty($this->_sql['order']))
		{
			$order = 'order by '.$this->_sql['order'];
		}
		else
		{
			$order ='';
		}

		if(!empty($this->_sql['limit']))
		{
			$limit = 'limit '.$this->_sql['limit'];
		}
		else
		{
			$limit ='';
		}

		if(!empty($this->_sql['offset']))
		{
			$offset = 'offset '.$this->_sql['offset'];
		}
		else
		{
			$offset ='';
		}

		if(!empty($this->_sql['use_keys']))
		{
			$use_keys = "USE KEYS ".$this->_sql['use_keys'];
		}
		else
		{
			$use_keys ='';
		}

		$queryStr = sprintf("SELECT %s FROM %s %s %s %s %s %s",$field,$bucket,$use_keys,$where,$order,$limit,$offset);
		$query = $this->n1ql_query($queryStr);
		if (empty($this->_sql['field'])) {
			$rs = array();
			foreach ($query->rows as $q) {
				$rs[] = $q->{$bucket};
			}
		}
		else {
			$rs = $query->rows;
		}

        unset($query);

        return $rs;

    }

    public function n1ql_query($n1ql = '') {
        $query = CouchbaseN1qlQuery::fromString($n1ql);
        return $this->bucket->query($query);
    }
}