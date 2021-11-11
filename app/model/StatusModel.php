<?php

/**
 * Status Model Class
 *
 * @package     REST
 * @author      Mohamad Febrian Mosii <febrianaries@gmail.com>
 * @link        https://febrian.info
 */
class StatusModel
{
    /**
     * Getting status name from database based on id
     *
     * @param   int     $id   Status ID  
     * @return  object
     */
    public static function getStatusNameById($id)
    {
        return QB::table('ref_statuses')->find($id)->name;
    }
}
