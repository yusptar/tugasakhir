<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SantriController extends Controller
{
    public function index() {
		return view('manage_admin.santri_manage');
	}

    public function fetchAll() {
		$emps = Santri::all();
		$output = '';
		$numbering = 1;
		if ($emps->count() > 0) {
			$output .= '<table class="table table-bordered data-table">
            <thead>
              <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
                <th>Asal</th>
                <th>Tahun Masuk</th>
                <th>Nama Ayah</th>
                <th>Nama Ibu</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($emps as $emp) {
				$output .= '<tr>
                <td width="5px">' . $numbering++ . '</td>
                <td><img src="storage/images/' . $emp->image . '" width="100" height="100" src="https://via.placeholder.com/150"></td>
                <td>' . $emp->nama . '</td>
                <td>' . $emp->ttl . '</td>
                <td>' . $emp->asal . '</td>
                <td>' . $emp->tahun_masuk . '</td>
                <td>' . $emp->nama_ayah . '</td>
                <td>' . $emp->nama_ibu . '</td>
                
                
                <td>
                  <a href="#" id="' . $emp->id . '" class="edit btn btn-primary btn-sm editIcon" data-bs-toggle="modal" data-bs-target="#editKegiatanModal"><i class="bi-pencil-square h4"></i>Edit</a>

                  <a href="#" id="' . $emp->id . '" class="btn btn-danger btn-sm deleteIcon"><i class="bi-trash h4"></i>Delete</a>

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
        $file = $request->file('image');
		$fileName = time() . '.' . $file->getClientOriginalExtension();
		$file->storeAs('public/images', $fileName);

		$empData = ['nama' => $request->nama, 'ttl' => $request->ttl, 'asal' => $request->asal, 'tahun_masuk' => $request->tahun_masuk, 'nama_ayah' => $request->nama_ayah, 'nama_ibu' => $request->nama_ibu, 'image' => $fileName];
		Santri::create($empData);
		return response()->json([
			'status' => 200,
		]);
    }

    public function edit(Request $request)
    {   
        $id = $request->id;
		$emp = Santri::find($id);
		return response()->json($emp);
    }

    public function update(Request $request) {
		$fileName = '';
		$emp = Santri::find($request->emp_id);
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

		$empData = ['nama' => $request->nama, 'ttl' => $request->ttl, 'asal' => $request->asal, 'tahun_masuk' => $request->tahun_masuk, 'nama_ayah' => $request->nama_ayah, 'nama_ibu' => $request->nama_ibu, 'image' => $fileName];

		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	}

    public function delete(Request $request) {
		$id = $request->id;
		$emp = Santri::find($id);
		if (Storage::delete('public/images/' . $emp->image)) {
			Santri::destroy($id);
		}
	}
}
