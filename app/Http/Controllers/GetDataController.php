<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class GetDataController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function getData(Request $request)
    { 
	$request_data = $request->json()->all();

	$acc_info  = DB::table('scpf_data')
			->join('clid_data', 'scpf_data.id_clid', '=', 'clid_data.id_clid')
			->select('clid_data.forma',
				'scpf_data.acc_number',
				'scpf_data.id_clid',
				'scpf_data.dateopen',
				'scpf_data.dateclose',
				'scpf_data.source_open'
				);

	isset($request_data['ID_CLID']) ? $acc_info->where('clid_data.id_clid', $request_data['ID_CLID']) : 0;
	isset($request_data['SOURCE_OPEN']) ? $acc_info->where('scpf_data.source_open', $request_data['SOURCE_OPEN']) : 0;
	isset($request_data['FORMA']) ? $acc_info->where('clid_data.forma', $request_data['FORMA']) : 0;
        
	return response()->json(['ACC' => $acc_info->get()]);
    }
}
