<?php

namespace App\Utils\Traits;


trait UserSessionAttributes
{
    public function setCurrentCompanyId($value) : void
    {
        session(['current_company_id' => $value]);
    }

    public function getCurrentCompanyId() : int
    {
        $temp = session('current_company_id');
        if(!isset($temp) || is_null($temp))
        {
            $temp = 1;
        }

        return $temp;
    }

}
