<?php

/**
 * Transaction Model Class
 *
 * @package     REST
 * @author      Mohamad Febrian Mosii <febrianaries@gmail.com>
 * @link        https://febrian.info
 */

class TransactionModel
{
    /**
     * Searching row using invoice ID
     *
     * @param   string   $invoiceId   Valid invoice id  
     * @return  object
     */
    public static function findByInvoiceId($invoiceId)
    {
        return QB::table('transactions')->where('invoice_id', $invoiceId)->first();
    }
    
    /**
     * Searching row using references id (encrypted id)
     *
     * @param   string   $referenceId   Valid references id 
     * @return  object
     */
    public static function findByReferencesId($referenceId)
    {
        return QB::table('transactions')->where(QB::raw('sha1(id)'), $referenceId)->first();
    }
    
    /**
     * Searching row using VA Number
     *
     * @param   string   $number_va   Valid VA Number
     * @return  object
     */
    public static function findByVA($number_va)
    {
        return QB::table('transactions')->where('number_va', $number_va)->first();
    }

    /**
     * Create new data
     *
     * @param   array   $data   Payloads of data
     * @return  object
     */
    public static function create($data)
    {        
        return QB::table('transactions')->insert($data);
    }

    /**
     * Retrieve transactions data
     *
     * @param   int     $merchantId    Valid merchant ID
     * @param   int     $referenceId   Valid reference ID
     * @return  object
     */
    public static function getTransactions($merchantId, $referenceId = '')
    {        
        if ($referenceId) {
            $result = QB::table('transactions')->where(QB::raw('sha1(id)'), $referenceId)->first();
        } else {
            $result = QB::table('transactions')->where("merchant_id", $merchantId)->get();
        }

        return $result;
    }

    /**
     * Retrieve transactions data
     *
     * @param   array   $data   Payloads of data
     * @return  object
     */
    public static function updateTransaction($referenceId, $statusCode)
    {        
        $status = QB::table('ref_statuses')->where('code', $statusCode)->first();

        $data = [
            'ref_status_id' => $status->id,
            'updated_at'    => date('Y-m-d H:i:s')
        ];
        
        QB::table('transactions')->where(QB::raw('sha1(id)'), $referenceId)->update($data);
    }
}
