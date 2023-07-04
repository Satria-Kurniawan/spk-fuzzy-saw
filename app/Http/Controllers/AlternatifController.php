<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    public function getAlternatifData(){
        $dataAlternatif = Alternatif::all();
        $dataKriteria = Kriteria::pluck('nama')->toArray();

        $modifiedArray = array_map(function($item) {
            return str_replace(' ', '_', $item);
        }, $dataKriteria);

        return view('data-alternatif', [
            'dataAlternatif' => $dataAlternatif,
            'dataKriteria' => $modifiedArray
        ]);
    }

    public function addAlternatif(Request $req){
        try {
            $data = $req->all();

            unset($data['_token']);
            unset($data['nama']);

            $data = array_map('floatval', $data);

            $validatedData = $req->validate([
                'nama' => 'required|string'
            ]);

            Alternatif::create([
                'nama' => $validatedData['nama'],
                'data' => $data
            ]);

            notify()->success('Berhasil menambahkan data alternatif.');

            return redirect()->back();
        } catch (\Exception $error) {
            notify()->error($error->getMessage());

            return redirect()->back();
        }
    }

    public function updateAlternatif(Request $req, $id){
        try {
            $data = $req->all();

            unset($data['_token']);
            unset($data['nama']);

            $data = array_map('floatval', $data);

            $validatedData = $req->validate([
                'nama' => 'required|string'
            ]);

            $alternatif = Alternatif::findOrFail($id);

            $alternatif->update([
                'nama' => $validatedData['nama'],
                'data' => $data
            ]);

            notify()->success('Berhasil memperbarui data alternatif.');

            return redirect()->back();
        } catch (\Exception $error) {
            notify()->error($error->getMessage());

            return redirect()->back();
        }
    }

    public function deleteAlternatif($id){
        try {
            $alternatif = Alternatif::findOrFail($id);
            $alternatif->delete();

            notify()->success('Berhasil menghapus data alternatif.');

            return redirect()->back();
        } catch (\Exception $error) {
            notify()->error($error->getMessage());

            return redirect()->back();
        }
    }
}
