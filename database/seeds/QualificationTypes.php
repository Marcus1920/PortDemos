<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\QualificationType;


class QualificationTypes extends Seeder
{
    public function run()
    {
        
        DB::table('qualification_types')->truncate();
        QualificationType::create(['id' => '1','slug' => 'Matric','name' => 'Matric']);
        QualificationType::create(['id' => '2','slug' => 'Certificate/Diploma','name' => 'Certificate/Diploma']);
        QualificationType::create(['id' => '3','slug' => 'Undergraduate','name' => 'Undergraduate']);
      
       

    }
}
