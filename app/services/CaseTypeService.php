<?php

namespace App\services;
use App\CaseType;


class CaseTypeService
{

    public function getCaseTypes(){

        return CaseType::all();
    }

}