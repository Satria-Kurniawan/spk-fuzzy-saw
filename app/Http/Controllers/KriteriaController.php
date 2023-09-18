<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Fuzzy;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function getKriteriaData()
    {
        $dataKriteria = Kriteria::all();

        return view('data-kriteria', [
            'dataKriteria' => $dataKriteria
        ]);
    }

    public function addKriteria(Request $req)
    {
        try {
            $validatedData = $req->validate([
                'nama' => 'required|string',
                'bobot' => 'required|numeric',
                'is_benefit' => 'required|boolean'
            ]);

            Kriteria::create($validatedData);

            notify()->success('Berhasil menambahkan data kriteria');

            return redirect()->back();
        } catch (\Exception $error) {
            notify()->error($error->getMessage());

            return redirect()->back();
        }
    }

    public function updateKriteria(Request $req, $id)
    {
        try {
            $validatedData = $req->validate([
                'nama' => 'required|string',
                'bobot' => 'required|numeric',
                'is_benefit' => 'required|boolean'
            ]);

            // Dapatkan kriteria lama
            $kriteriaLama = Kriteria::findOrFail($id);

            $namaKriteriaLama = str_replace(' ', '_', $kriteriaLama->nama);
            $namaKriteriaBaru = str_replace(' ', '_', $validatedData['nama']);

            // Dapatkan semua alternatif
            $alternatifs = Alternatif::all();

            // Perbarui nilai kriteria lama dengan kriteria baru pada setiap alternatif
            foreach ($alternatifs as $alternatif) {
                $data = $alternatif->data;

                // Pastikan kriteria lama ada dalam data alternatif
                if (isset($data[$namaKriteriaLama])) {
                    // Buat kunci baru dengan nama kriteria baru dan nilai yang sama
                    $data[$namaKriteriaBaru] = $data[$namaKriteriaLama];

                    // Hapus kunci lama
                    unset($data[$namaKriteriaLama]);

                    $alternatif->data = $data; // Simpan kembali sebagai string JSON
                    $alternatif->save();
                }
            }

            // Perbarui kriteria lama dengan data kriteria baru
            $kriteriaLama->update($validatedData);

            notify()->success('Berhasil memperbarui data kriteria dan mengupdate data pada alternatif yang terkait.');

            return redirect()->back();
        } catch (\Exception $error) {
            notify()->error($error->getMessage());

            return redirect()->back();
        }
    }
}
