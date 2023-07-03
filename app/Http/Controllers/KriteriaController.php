<?php

namespace App\Http\Controllers;

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

            return redirect()->back();
        } catch (\Exception $error) {
            dd($error);
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

            return redirect()->back();
        } catch (\Exception $error) {
            dd($error);
        }
    }

    public function deleteKriteria($id){
        try {
            $kriteria = Kriteria::findOrFail($id);
            $kriteria->delete();

            return redirect()->back();
        } catch (\Exception $error) {
            dd($error);
        }
    }
}
