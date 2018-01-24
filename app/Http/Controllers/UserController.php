<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\UserProfileController;
use App\Models\UserProfile;
use Session;
use Illuminate\Contracts\Auth\Guard;

class UserController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| User Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index(Guard $auth)
	{
		$userProfile = new UserProfile();
		$userprofile = $userProfile::where('user_id', $auth->user()->id)->first();
		return view('userprofile', ['profile' => $userprofile ]);
	}

	public function add(Request $request) {
		echo "coming";exit;
		$userProfile = new UserProfile();
		$userProfile->user_id = $request->userId;
		$userProfile->first_name = $request->firstName;
		$userProfile->last_name = $request->lastName;
		$userProfile->dob = $request->dob;
		$userProfile->gender = $request->gender;
		if($userProfile->save()){
			return redirect('user/profile');
		}
	}

	public function edit(Request $request) {
		$user = UserProfile::find(1);
		$user->first_name = $request->firstName;
		$user->last_name = $request->lastName;
		$user->dob = $request->dob;
		$user->gender = $request->gender;
		//$userProfile->save();
			if($user->save()){
			//Session::flash('flash_message','Office successfully added.');
			return redirect('user/profile')->with('success', 'Record updated.');;
		}
	}

}
