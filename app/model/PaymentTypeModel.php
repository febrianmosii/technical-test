<?php

/**
 * Payment Type Model Class
 *
 * @package     REST
 * @author      Mohamad Febrian Mosii <febrianaries@gmail.com>
 * @link        https://febrian.info
 */
class PaymentTypeModel
{
    /**
     * Getting data from database based on code
     *
     * @param   string  $code   Payment Type Code  
     * @return  object
     */
    public static function getIdByCode($code)
    {
        $result = QB::table('ref_payment_types')->where('code', $code)->first()->id;
        
        return $result;
    }
}
