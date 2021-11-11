<?php

/**
 * Merchant Model Class
 *
 * @package     REST
 * @author      Mohamad Febrian Mosii <febrianaries@gmail.com>
 * @link        https://febrian.info
 */
class MerchantModel
{
    /**
     * Getting data from database based on id
     *
     * @param   int     $id     Merchant ID      
     * @return  object
     */
    public static function findById($id)
    {
        return QB::table('ref_merchants')->find($id);
    }
}
