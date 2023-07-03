<?php

namespace App\Http\Controllers;

use App\Models\Fuzzy;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class FuzzyController extends Controller
{
    public function getFuzzyData(){
        $dataKriteria = Kriteria::all();
        $dataFuzzy = Fuzzy::all();

        return view('data-fuzzy', [
            'dataKriteria' => $dataKriteria,
            'dataFuzzy' => $dataFuzzy
        ]);
    }

    public function addFuzzy(Request $req, $idKriteria){
        try {
            $validatedData = $req->validate([
                'keterangan' => 'required|string',
                'operator' => 'required|string',
                'nilai_start' => 'numeric',
                'nilai_end' => 'numeric',
                'nilai_persyaratan' => 'numeric',
                'nilai_fuzzy' => 'required|numeric',
            ]);

            Fuzzy::create([
                'keterangan' => $validatedData['keterangan'],
                'operator' => $validatedData['operator'],
                'nilai_start' => $validatedData['nilai_start'],
                'nilai_end' => $validatedData['nilai_end'],
                'nilai_persyaratan' => $validatedData['nilai_persyaratan'],
                'nilai_fuzzy' => $validatedData['nilai_fuzzy'],
                'id_kriteria' => intval($idKriteria),
            ]);

            return redirect()->back();
        } catch (\Exception $error) {
            dd($error);
        }
    }

    public function updateFuzzy(Request $req, $idKriteria, $idFuzzy){
        try {
            $validatedData = $req->validate([
                'keterangan' => 'required|string',
                'operator' => 'required|string',
                'nilai_start' => 'numeric',
                'nilai_end' => 'numeric',
                'nilai_persyaratan' => 'numeric',
                'nilai_fuzzy' => 'required|numeric',
            ]);

            $fuzzy = Fuzzy::findOrFail($idFuzzy);

            $fuzzy->update([
                'keterangan' => $validatedData['keterangan'],
                'operator' => $validatedData['operator'],
                'nilai_start' => $validatedData['nilai_start'],
                'nilai_end' => $validatedData['nilai_end'],
                'nilai_persyaratan' => $validatedData['nilai_persyaratan'],
                'nilai_fuzzy' => $validatedData['nilai_fuzzy'],
                'id_kriteria' => intval($idKriteria),
            ]);

            return redirect()->back();
        } catch (\Exception $error) {
            dd($error);
        }
    }

    public function deleteFuzzy($id){
        try {
            $fuzzy = Fuzzy::findOrFail($id);
            $fuzzy->delete();

            return redirect()->back();
        } catch (\Exception $error) {
            dd($error);
        }
    }
}
