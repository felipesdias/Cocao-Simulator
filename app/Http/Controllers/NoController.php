<?php

namespace App\Http\Controllers;

use App\No;
use Illuminate\Http\Request;

class NoController extends Controller
{
    public function geraApelido() {
    	$id = 1;
    	$apelido = "";
    	$ids = [];
    	$end = false;
    	$aux = true;

    	while(count($apelido) < 5 && !$end && $aux) {
    		array_push($ids, $id);
    		$no = No::find($id);
    		$chute = rand(0,270000);
    		$total = 0;
    		$end = false;
    		$aux = false;

    		for($c = 97; $c < 123; $c += 1) {
    			$result = explode("|", $no[chr($c)]);
    			$qt = intval($result[0]);


    			$total += $qt;

    			if($chute < $total) {
    				$apelido = $apelido.chr($c);
    				if(count($result) > 1)
	    				$id = intval($result[1]);
	    			else
	    				$end = true;
	    			$aux = true;
	    			break;
	    		}
    		}
    	}
    	return response()->success(compact('apelido', 'ids'));
    }
}