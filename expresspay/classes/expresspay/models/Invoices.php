<?php

/**
 * Data Access Object (DAO) for messages.
 *  Performs operations on database.
 * @author LLC «TriIncom»
 * @package ExpressPay Payment Module
 * @subpackage Model
 * @since 1.00
 */
class ExpressPayInvoiceModel extends DAO
{
    function __construct()
    {
        parent::__construct();
        $this->setTableName('expresspay_invoices');
        $this->setPrimaryKey('id');
        $this->setFields(array('id','amount','description','itemnumber','extra','datecreated','status','dateofpayment','options','options_id'));
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
    public function maxId()
    {
        $this->dao->select('max(id) as id');
        $this->dao->from($this->getTableName());

        $result = $this->dao->get_row();
        if($result == false) {
            return array();
        }

        return $result->result();
    }
    
    public function insertInvoice($amount, $description, $extra, $itemnumber, $optionsid)
    {
        $sql = sprintf("INSERT INTO %s (amount, description, extra, itemnumber, status, options_id, datecreated) VALUES (%01.2f, '%s', '%s', '%s', 0, %d, CURRENT_TIMESTAMP());", $this->getTableName(), $amount,  $description, $extra, $itemnumber, $optionsid);
        
        $result = $this->dao->query($sql);

        return $this->dao->insertedId();
    }
    /**
     * {@inheritDoc}
     */
    public function updateInvoiceStatus($id, $status)
    {
        return $this->updateByPrimaryKey(array('status' => $status), $id);
    }

    /**
     * {@inheritDoc}
     */
    public function updateInvoiceDateOfPayment($id, $dateofpayment)
    {
        return $this->updateByPrimaryKey(array('dateofpayment' => $dateofpayment), $id);
    }
}