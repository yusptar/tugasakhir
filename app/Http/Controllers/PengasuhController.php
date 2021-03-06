<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Santri;
use App\Models\Donation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PengasuhController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data_santri = Santri::all();
        $data_donatur = User::all()->where('roles', 'Donatur');
        $donasi_donatur = Donation::where('donatur_id', Auth::user()->id)->latest()->sum('gross_amount');
        return view('pengasuh.pengasuh', compact('data_santri', 'data_donatur', 'donasi_donatur'));
    }
    public function index_table()
    {
        return view('manage_admin.pengasuh_manage');
    }
    public function fetchAll() {
		$emps = User::all()->where('roles', 'Pengasuh');
		$output = '';
		$numbering = 1;
		if ($emps->count() > 0) {
			$output .= '<table class="table table-bordered data-table">
            <thead>
              <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Name</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>No. Hp</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($emps as $emp) {
				$output .= '<tr>
                <td width="5px">' . $numbering++ . '</td>
                <td><img src="storage/images/' . $emp->image . '" width="100" height="100" src="https://via.placeholder.com/150"></td>
                <td>' . $emp->name . '</td>
                <td>' . $emp->email . '</td>
                <td>' . $emp->alamat . '</td>
                <td>' . $emp->nohp . '</td>
                <td>
                  <a href="#" id="' . $emp->id . '" class="edit btn btn-primary btn-sm editIcon" data-bs-toggle="modal" data-bs-target="#editPengasuhModal"><i class="bi-pencil-square h4"></i>View</a>


                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
		}
	}

    public function store(Request $request)
    {  
    //     $file = $request->file('image');
		// $fileName = time() . '.' . $file->getClientOriginalExtension();
		// $file->storeAs('public/images', $fileName);

		// $empData = ['name' => $request->name, 'email' => $request->email, 'alamat' => $request->alamat, 'nohp' => $request->nohp, 'instansi' => $request->instansi, 'image' => $fileName];
		// User::create($empData);
		
    User::updateOrCreate(['id' => $request->user_id],
                [
                    'name' => $request->name, 
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'roles' => $request->roles
                ]);        
   
                return response()->json([
                  'status' => 200,
                ]);
    }

    public function edit(Request $request)
    {   
        $id = $request->id;
        // $emp = User::find($id)->where('roles', 'Pengasuh');
		    $emp = User::find($id);
		    return response()->json($emp);
    }

    public function update(Request $request) {
		$fileName = '';
		$emp = User::find($request->emp_id);
		if ($request->hasFile('image')) {
			$file = $request->file('image');
			$fileName = time() . '.' . $file->getClientOriginalExtension();
			$file->storeAs('public/images', $fileName);
			if ($emp->image) {
				Storage::delete('public/images/' . $emp->image); 
			}
		} else {
			$fileName = $request->emp_image;
		}

		$empData = ['name' => $request->name, 'email' => $request->email, 'alamat' => $request->alamat, 'nohp' => $request->nohp, 'instansi' => $request->instansi, 'image' => $fileName];

		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	}

    public function delete(Request $request) {
      User::find($id)->delete(); 
	}
}
