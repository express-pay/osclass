<?php

/**
 * Data Access Object (DAO) for messages.
 *  Performs operations on database.
 * @author LLC «TriIncom»
 * @package ExpressPay Payment Module
 * @subpackage Model
 * @since 1.00
 */
class ExpressPayOptionsModel extends DAO
{
    function __construct()
    {
        parent::__construct();
        $this->setTableName('expresspay_options');
        $this->setPrimaryKey('id');
        $this->setFields(array('id','name','type', 'options','isactive'));
    }

    /**
     * Singleton.
     */
    private static $instance;

    /**
     * Singleton constructor.
     * @return an ExpressPayOptionsDAO object.
     */
    public static function newInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * {@inheritDoc}
     */
    public function listAll($page = null, $length = null)
    {
        $this->dao->select($this->getFields());
        $this->dao->from($this->getTableName());

        if (!is_null($page) && !is_null($length)) {
            $this->dao->limit($page - 1, $length);
        }

        $result = $this->dao->get();
        if($result == false) {
            return array();
        }

        return $result->result();
    }
}