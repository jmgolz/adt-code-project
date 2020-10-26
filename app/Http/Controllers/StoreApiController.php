<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class StoreApiController extends Controller
{
    private $dollarDenominations = array(100, 50, 20, 10, 5, 1);
    private $centDenominations = array(25, 10, 5, 1);


    public function getChangeOwed(Request $request)
    {
        $amountOwed = explode('.', ($request['amountPaid'] - $request['orderTotal']));
        $amountOwedByDenomination = array();

        // Calculate dollar amounts
        for ($i = 0; $i < count($this->dollarDenominations); $i++) {
            if ($amountOwed[0] >= $this->dollarDenominations[$i]) {
                $tempAmount = intval($amountOwed[0] / $this->dollarDenominations[$i]);

                $amountOwedByDenomination['dollars'][$this->dollarDenominations[$i]] = $tempAmount;
                $amountOwed[0] = $amountOwed[0] - ($amountOwedByDenomination['dollars'][$this->dollarDenominations[$i]] * $this->dollarDenominations[$i]);
            }
        }

        // Calculate cents if applicable.
        if (count($amountOwed) > 1) {
            for ($i = 0; $i < count($this->centDenominations); $i++) {
                if ($amountOwed[1] >= $this->centDenominations[$i]) {
                    $tempAmount = intval($amountOwed[1] / $this->centDenominations[$i]);
    
                    $amountOwedByDenomination['cents'][$this->centDenominations[$i]] = $tempAmount;
                    $amountOwed[1] = $amountOwed[1] - ($amountOwedByDenomination['cents'][$this->centDenominations[$i]] * $this->centDenominations[$i]);
                }
            }   
        }
        return response()->json($amountOwedByDenomination);
    }
}
