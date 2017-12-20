<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class requestController extends Controller
{
        public function index(Request $req)
        {
        	$userid = session()->get('user_id');
        	$from = htmlspecialchars($req->input('from'));
        	$to = htmlspecialchars($req->input('to'));

        	if($from == $userid)
        	{
        		$query = \DB::table("request")->where('request_from',$from)->where('request_to',$to)->first();
            
      			$count = count($query);

      			if($count>0)
      			{
      				echo '<button id="unfollow" class="btn btn-danger" onclick="request_unfollow()"><i class="fa fa-minus"></i>Unfollow</button>';
      			}
      			else
      			{
      				echo '<button id="follow" class="btn btn-primary" onclick="request_follow()"><i class="fa fa-plus"></i>Follow</button>';
      			}

        	}

        }

        public function follow(Request $req)
        {

	        	$userid = session()->get('user_id');
	        	$from = htmlspecialchars($req->input('from'));
	        	$to = htmlspecialchars($req->input('to'));

	        	if($from == $userid)
	        	{
	            
					     $time = date("Y-m-d h:i:s");

	      			\DB::insert('insert into request(request_from,request_to,request_time) values(?,?,?)',[$from,$to,$time]);



	        	}

        }


        public function unfollow(Request $req)
        {

	        	$userid = session()->get('user_id');
	        	$from = htmlspecialchars($req->input('from'));
	        	$to = htmlspecialchars($req->input('to'));

	        	if($from == $userid)
	        	{
	            

					\DB::table('request')->where('request_from', $from)->where('request_to',$to)->delete();



	        	}

        }


}
