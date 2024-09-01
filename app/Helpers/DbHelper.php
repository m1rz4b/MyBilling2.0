<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

      function pick($TableName, $FieldName, $Condition)
      {
            if ($Condition == null) {
                  $query = "Select $FieldName from $TableName";
            } else {
                  $query = "Select $FieldName from $TableName where $Condition";
            }

            $ResultSet = DB::select($query);

            return $ResultSet;
      }

      function dateDifference($date_1 , $date_2 , $differenceFormat )
      {
            $datetime1 = date_create($date_1);
            $datetime2 = date_create($date_2);
            
            $interval = date_diff($datetime1, $datetime2);
            
            return $interval->format($differenceFormat);
            
      }