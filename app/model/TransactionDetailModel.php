<?php

/**
 * Transaction Detail Model Class
 *
 * @package     REST
 * @author      Mohamad Febrian Mosii <febrianaries@gmail.com>
 * @link        https://febrian.info
 */
class TransactionDetailModel
{
    /**
     * Batch inserting to database
     *
     * @param   array   $data   Array of objects  
     * @return  object
     */
    public static function createBatch($data = [])
    {        
        return QB::table('transaction_details')->insert($data);
    }
}
