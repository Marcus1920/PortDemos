<?php

namespace App\services\v1;
use App\CaseReport;
use App\Driver;
use App\DriverCompany;
use App\DriverVehicle;
use App\CaseType;
use App\CaseSubType;
use App\CaseOwner;
use App\services\CaseOwnerService;
use App\services\CaseResponderService;



class CaseService {

    protected $case_responders;
    protected $case_owners;

   public function __construct(CaseResponderService $responder_service,CaseOwnerService $case_owner_service) {

        $this->case_responders = $responder_service;
        $this->case_owners     = $case_owner_service;

    }


    public function getCases() {

        return CaseReport::all();
    }


    public function get_case($id){

       return CaseReport::find($id);
    }



    public function checkDriverExist($idNo,$licenceNo) {

        if(Driver::where('idNumber',$idNo)->where('driverLicenceNo',$licenceNo)->exists()){
            return TRUE;
        }else {

            return FALSE;
        }


    }

    public function checkCompanyExist($companyRegNo){

        if(DriverCompany::where('CompanyRegNo',$companyRegNo)->exists()){
            return TRUE;
        }else {

            return FALSE;
        }

    }

    public function createCase($req){


        $driverCompanyName          = $req->input('DriverCompany.CompanyName');
        $driverCompanyContactNumber = $req->input('DriverCompany.CompanyContactNumber');
        $driverCompanyRegNo         = $req->input('DriverCompany.CompanyRegNo');

         $company_exist             = $this->checkCompanyExist($driverCompanyRegNo);

         if(!$company_exist) {

             $company                       = new DriverCompany();
             $company->CompanyName          = $driverCompanyName;
             $company->ContactNumber        = $driverCompanyContactNumber;
             $company->CompanyRegNo         = $driverCompanyRegNo;
             $company->save();
         } else {

             $company = DriverCompany::where('CompanyRegNo',$driverCompanyRegNo)->first();

         }

           //Create Driver
           $driverFirsName              = $req->input('Driver.FirstName');
           $driverSurname               = $req->input('Driver.LastName');
           $driverIDNumber              = $req->input('Driver.IdNumber');
           $driverCellphone             = $req->input('Driver.Cellphone');
           $driverLicenceNo             = $req->input('Driver.driverLicenceNo');
           $driver_exist                = $this->checkDriverExist($driverIDNumber,$driverLicenceNo);
            if(!$driver_exist){

                $driver                  = new Driver();
                $driver->FirstName       = $driverFirsName;
                $driver->LastName        = $driverSurname;
                $driver->IDNumber        = $driverIDNumber;
                $driver->Cellphone       = $driverCellphone;
                $driver->DriverLicenceNo = $driverLicenceNo;
                $driver->companyId       = $company->id;
                $driver->save();

            } else {

                $driver = Driver::where('DriverLicenceNo',$driverLicenceNo)->first();
            }


                //Create Vehicle Company
                $driverVehicleModel         = $req->input('Vehicle.Model');
                $driverVehicleMake          = $req->input('Vehicle.Make');
                $driverVehicleColor         = $req->input('Vehicle.Color');
                $driverVehicleRegNo         = $req->input('Vehicle.VehicleRegNo');
                $driverVehicleTimeIn        = $req->input('Vehicle.timeIn');
                $driverVehiclePurpose       = $req->input('Vehicle.purpose');


                $vehicle                    = new DriverVehicle();
                $vehicle->Model             = $driverVehicleModel;
                $vehicle->Make              = $driverVehicleMake;
                $vehicle->Color             = $driverVehicleColor;
                $vehicle->VehicleRegNo      = $driverVehicleRegNo;
                $vehicle->driver_id         = $driver->id;
                $vehicle->company_id        = $company->id;
                $vehicle->timeIn            = $driverVehicleTimeIn;
                $vehicle->purpose           = $driverVehiclePurpose;
                $vehicle->save();

                //Create Case
                $IncidentType               = $req->input('Incident.IncidentType');
                $IncidentDateTime           = $req->input('Incident.IncidentDateTime');
                $IncidentDescription        = ($req->input('Incident.IncidentDescription'))?  $req->input('Incident.IncidentDescription'): "Gate Track Case";
                $Port                       = $req->input('Incident.Port');
                $Gate                       = $req->input('Incident.Gate');

                //Get Case Type Id
                $caseType                   = CaseType::where('name',$IncidentType)->first();
                $case_sub_type              = CaseSubType::where('name',$IncidentType)->first();

                if(CaseType::where('name',$IncidentType)->exists()) {

                    $case = new CaseReport();
                    $case->description              = $IncidentDescription;
                    $case->department               = 1;
                    $case->status                   = 1;
                    $case->active                   = 1;
                    $case->source                   = 4;
                    $case->reporter                 = 1;
                    $case->user                     = 1;
                    $case->priority                 = 1;
                    $case->gatetrack_id             = $vehicle->id;
                    $case->case_type                = $caseType->id;
                    $case->case_sub_type            = $case_sub_type->id;
                    $case->save();

                    $create_case_owner_data = array(
                                                    "case_id"      => $case->id,
                                                    "user"         => 1,
                                                    "type"         => 1,
                                                    "addressbook"  => 0
                                                    );
                    $this->case_owners->create_case_owner($create_case_owner_data);

                    $first_responders   = $this->get_responders_by_sub_case_type($case->case_sub_type,1);

                    foreach ($first_responders as $first_responder){

                        $create_case_owner_data = array(
                            "case_id"      => $case->id,
                            "user"         => $first_responder->responder,
                            "type"         => 0,
                            "addressbook"  => 0
                        );

                        $this->case_owners->create_case_owner($create_case_owner_data);

                    }


                    $this->case_responders->send_comms_to_first_responders($case,$first_responders);

                    return $case;
                }


    }


}