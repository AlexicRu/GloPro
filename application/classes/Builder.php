<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Builder
 *
 * simple query builder
 *
 * todo having, group, join, leftjoin
 */
class Builder
{
    private $_action    = '';
    private $_from      = '';
    private $_columns   = [];
    private $_where     = [];
    private $_orderBy   = [];
    private $_limit     = 0;
    private $_offset    = 0;
    private $_distinct  = false;

    /**
     * @return $this
     */
    public function select($array = [])
    {
        $this->columns($array);

        $this->_action = 'select';

        return $this;
    }

    /**
     * @return $this
     */
    public function distinct()
    {
        $this->_distinct = true;

        return $this;
    }

    /**
     * @param $str
     * @return $this
     */
    public function from($str)
    {
        if (empty($str)) {
            return $this;
        }

        $this->_from = Oracle::$prefix . $str;

        return $this;
    }

    /**
     * @param $array
     * @return $this
     */
    public function columns($array)
    {
        if (empty($array)) {
            return $this;
        }
        if (is_string($array)) {
            $array = [$array];
        }

        $this->_columns = array_merge($this->_columns, $array);

        return $this;
    }

    /**
     * @param $connector
     * @return $this
     */
    public function whereStart($connector = 'and')
    {
        $this->_where[] = [
            'connector'             => $connector,
            'where'                 => '(',
            'skip_next_connector'   => true
        ];

        return $this;
    }

    /**
     * @return $this
     */
    public function whereEnd()
    {
        $this->_where[] = [
            'connector' => '',
            'where'     => ')',
        ];

        return $this;
    }

    /**
     * @param $where
     * @return $this
     */
    public function whereOr($where)
    {
        if (empty($where)) {
            return $this;
        }

        $this->_where[] = [
            'connector' => 'or',
            'where'     => $where,
        ];

        return $this;
    }

    /**
     * @param $where
     * @return $this
     */
    public function where($where)
    {
        if (empty($where)) {
            return $this;
        }

        $this->_where[] = [
            'connector' => 'and',
            'where'     => $where,
        ];

        return $this;
    }

    /**
     * @param $array
     * @return $this
     */
    public function orderBy($array)
    {
        if (empty($array)) {
            return $this;
        }
        if (is_string($array)) {
            $array = [$array];
        }

        $this->_orderBy = array_merge($this->_orderBy, $array);

        return $this;
    }

    /**
     * @param $int
     * @return $this
     */
    public function limit($int)
    {
        if (empty($int)) {
            return $this;
        }

        $this->_limit = (int)$int;

        return $this;
    }

    /**
     * @param $int
     * @return $this
     */
    public function offset($int)
    {
        if (empty($int)) {
            return $this;
        }

        $this->_offset = (int)$int;

        return $this;
    }

    /**
     * сбрасываем параметры
     */
    public function resetColumns()
    {
        $this->_columns = [];
    }
    public function resetOrderBy()
    {
        $this->_orderBy = [];
    }

    /**
     * собираем из этого всего SQL
     */
    public function build()
    {
        $sql = " {$this->_action} ";

        if ($this->_distinct) {
            $sql .= " distinct ";
        }

        //columns
        if (empty($this->_columns)) {
            $sql .= " * ";
        } else {
            $sql .= " ".implode(" , ", $this->_columns)." ";
        }

        //from
        $sql .= " from {$this->_from} ";

        //where
        if (!empty($this->_where)) {
            $sql .= " where ";

            $skipNextConnector = true;

            foreach($this->_where as $where) {
                if (empty($skipNextConnector)) {
                    $sql .= " {$where['connector']} ";
                }

                $sql .= " {$where['where']} ";

                if (!empty($where['skip_next_connector'])) {
                    $skipNextConnector = true;
                } else {
                    $skipNextConnector = false;
                }
            }
        }

        //order by
        if (!empty($this->_orderBy)) {
            $sql .= " order by ".implode(" , ", $this->_orderBy)." ";
        }

        if (!empty($this->_limit) || !empty($this->_offset)) {
            $sql = "
                select * from (
                  select a.*, ROWNUM rnum from (
                    {$sql}
                  ) a where rownum <= ".($this->_limit ?: 999999999)."
                ) where rnum > ".$this->_offset."
            ";
        }

        return $sql;
    }
}