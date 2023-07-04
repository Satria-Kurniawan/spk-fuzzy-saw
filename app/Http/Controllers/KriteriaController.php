<?php

namespace App\Http\Controllers;

use App\Models\Fuzzy;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function getKriteriaData(){
        $dataKriteria = Kriteria::all();

        return view('data-kriteria', [
            'dataKriteria' => $dataKriteria
        ]);
    }

    public function addKriteria(Request $req){
        try {
            $validatedData = $req->validate([
                'nama' => 'required|string',
                'bobot' => 'required|numeric',
                'is_benefit'=> 'required|boolean'
            ]);

            Kriteria::create($validatedData);

            notify()->success('Berhasil menambahkan data kriteria');

            return redirect()->back();
        } catch (\Exception $error) {
            notify()->error($error->getMessage());

            return redirect()->back();
        }
    }

    public function updateKriteria(Request $req, $id){
        try {
            $validatedData = $req->validate([
                'nama' => 'required|string',
                'bobot' => 'required|numeric',
                'is_benefit'=> 'required|boolean'
            ]);

            $kriteria = Kriteria::findOrFail($id);
            $kriteria->update($validatedData);

            notify()->success('Berhasil memperbarui data kriteria');

            return redirect()->back();
        } catch (\Exception $error) {
            notify()->error($error->getMessage());

            return redirect()->back();
        }
    }

    public function deleteKriteria($id){
        try {
            $dataFuzzy = Fuzzy::where('id_kriteria', $id)->get();

            if(count($dataFuzzy) !== 0){
                notify()->error('Kriteria masih digunakan di data himpunan fuzzy, hapus data himpunan fuzzy yang menggunakan kriteria terkait.');
                return redirect()->back();
            }

            $kriteria = Kriteria::findOrFail($id);
            $kriteria->delete();

            notify()->success('Berhasil menghapus data kriteria');

            return redirect()->back();
        } catch (\Exception $error) {
            notify()->error($error->getMessage());

            return redirect()->back();
        }
    }
}
