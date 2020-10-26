<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class StoreApi extends Controller
{
    private $dollarDenominations = array(100, 50, 20, 10, 5, 1);


    public function getChangeOwed(Request $request)
    {
        $amountOwed = 2337.35;
        $amountOwedByDenomination = array();

        for ($i = 0; $i < count($this->dollarDenominations); $i++) {
            if ($amountOwed >= $this->dollarDenominations[$i]) {
                $tempAmount = intval($amountOwed / $this->dollarDenominations[$i]);

                $amountOwedByDenomination['dollars'][$this->dollarDenominations[$i]] = $tempAmount;
                $amountOwed = $amountOwed - ($amountOwedByDenomination['dollars'][$this->dollarDenominations[$i]] * $this->dollarDenominations[$i]);
            }
        }

        return response()->json($amountOwedByDenomination);
    }
}
