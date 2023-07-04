<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Fuzzy;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class SAWController extends Controller
{
    public function getDataPerhitungan(){
        $dataKriteria = Kriteria::all()->toArray();
        $dataAlternatif = Alternatif::all();
        $dataFuzzy = Fuzzy::with('kriteria')->get();

        foreach ($dataFuzzy as &$item) {
            $item['kriteria']['nama'] = str_replace(' ', '_', $item['kriteria']['nama']);
        }

        foreach ($dataAlternatif as $alternatif) {
            $dataPenilaian[$alternatif['nama']] = [];

            foreach ($alternatif['data'] as $alternatifKriteriaKey => $alternatifKriteriaValue) {
                foreach ($dataFuzzy as $fuzzy) {
                    if($alternatifKriteriaKey === $fuzzy['kriteria']['nama']){
                        if($fuzzy['operator'] === 'Range Nilai'){
                            if($alternatifKriteriaValue >= $fuzzy['nilai_start'] && $alternatifKriteriaValue <= $fuzzy['nilai_end']){
                                $dataPenilaian[$alternatif['nama']][$alternatifKriteriaKey] = [
                                    'Keterangan' => $fuzzy['keterangan'],
                                    'Nilai_Fuzzy' => $fuzzy['nilai_fuzzy'],
                                    'Atribut' => $fuzzy['kriteria']['is_benefit'] === 1 ? 'Benefit' : 'Cost',
                                    'Bobot' => $fuzzy['kriteria']['bobot']
                                ];
                            }
                        }else if($fuzzy['operator'] === 'Kurang Dari'){
                            if($alternatifKriteriaValue < $fuzzy['nilai_persyaratan']){
                                $dataPenilaian[$alternatif['nama']][$alternatifKriteriaKey] = [
                                    'Keterangan' => $fuzzy['keterangan'],
                                    'Nilai_Fuzzy' => $fuzzy['nilai_fuzzy'],
                                    'Atribut' => $fuzzy['kriteria']['is_benefit'] === 1 ? 'Benefit' : 'Cost',
                                    'Bobot' => $fuzzy['kriteria']['bobot']
                                ];
                            }
                        }else {
                            if($alternatifKriteriaValue > $fuzzy['nilai_persyaratan']){
                                $dataPenilaian[$alternatif['nama']][$alternatifKriteriaKey] = [
                                    'Keterangan' => $fuzzy['keterangan'],
                                    'Nilai_Fuzzy' => $fuzzy['nilai_fuzzy'],
                                    'Atribut' => $fuzzy['kriteria']['is_benefit'] === 1 ? 'Benefit' : 'Cost',
                                    'Bobot' => $fuzzy['kriteria']['bobot']
                                ];
                            }
                        }
                    }
                }
            }
        }

        $matriks = [];

        foreach ($dataPenilaian as $key => $values) {
            $row = [];
            foreach ($values as $value) {
                $row[] = [
                    'Nilai_Fuzzy' => $value["Nilai_Fuzzy"],
                    'Atribut' => $value['Atribut'],
                    'Bobot' => $value['Bobot']
                ];
            }
            $matriks[] = $row;
        }

        $numRows = count($matriks);
        $numCols = count($matriks[0]);

        $maxValues = array_fill(0, $numCols, PHP_INT_MIN); // Inisialisasi array dengan nilai minimum integer
        $minValues = array_fill(0, $numCols, PHP_INT_MAX); // Inisialisasi array dengan nilai maksimum integer

        for ($col = 0; $col < $numCols; $col++) {
            for ($row = 0; $row < $numRows; $row++) {
                $value = $matriks[$row][$col]['Nilai_Fuzzy'];
                $atribut = $matriks[$row][$col]['Atribut'];

                if ($atribut === "Benefit") {
                    $maxValues[$col] = max($maxValues[$col], $value);
                } elseif ($atribut === "Cost") {
                    $minValues[$col] = min($minValues[$col], $value);
                }
            }
        }

        $normalizedMatriks = [];

        for ($row = 0; $row < $numRows; $row++) {
            $normalizedRow = [];

            for ($col = 0; $col < $numCols; $col++) {
                $value = $matriks[$row][$col]['Nilai_Fuzzy'];
                $atribut = $matriks[$row][$col]['Atribut'];
                $bobot = $matriks[$row][$col]['Bobot'];

                if ($atribut === "Benefit") {
                    if ($maxValues[$col] != 0) {
                        $normalizedValue = $value / $maxValues[$col];
                    } else {
                        $normalizedValue = 0;
                    }
                } elseif ($atribut === "Cost") {
                    if ($value != 0) {
                        $normalizedValue = $minValues[$col] / $value;
                    } else {
                        $normalizedValue = 0;
                    }
                }

                $normalizedRow[] = [
                    'Nilai_Normalisasi' => $normalizedValue,
                    'Atribut' => $atribut,
                    'Bobot' => $bobot
                ];
            }

            $normalizedMatriks[] = $normalizedRow;
        }

        // dd($normalizedMatriks);

        $normalizedMatriksWithBobot = [];

        foreach ($normalizedMatriks as $index => $row) {
            $sumsRow = [];

            foreach ($row as $value) {
                $sumsRow[] = $value['Nilai_Normalisasi'] * $value['Bobot'];
            }
            $normalizedMatriksWithBobot[] = $sumsRow;
        }

        // dd($normalizedMatriksWithBobot);

        $dataDetailNormalizedMatriksWithBobot = [];

        for ($i=0; $i < count($dataAlternatif) ; $i++) {
            for ($j=0; $j < count($normalizedMatriksWithBobot) ; $j++) {
                $dataDetailNormalizedMatriksWithBobot[$dataAlternatif[$i]['nama']] =  $normalizedMatriksWithBobot[$i];
            }
        }

        // dd($dataDetailNormalizedMatriksWithBobot);

        $dataHasilPerhitungan = [];

        foreach ($dataDetailNormalizedMatriksWithBobot as $key => $values) {
            $sums = 0;

            foreach ($values as $value) {
                $sums += $value;

                $data = [
                    'Nama_Alternatif' => $key,
                    'Nilai_V' => $sums,
                    'Normalisasi_Terbobot' => $values
                ];
            }
            $dataHasilPerhitungan[] = $data;
        }

        // dd($dataHasilPerhitungan);

        return view('data-perhitungan', [
            'dataKriteria' => $dataKriteria,
            'dataAlternatif' => $dataAlternatif,
            'dataPenilaian' => $dataPenilaian,
            'matriks'=> $matriks,
            'normalizedMatriks' => $normalizedMatriks,
            'normalizedMatriksWithBobot' => $dataDetailNormalizedMatriksWithBobot,
            'dataHasilPerhitungan' => $dataHasilPerhitungan
        ]);
    }

    public function getDataPerankingan(){
        $dataPerhitungan = $this->getDataPerhitungan();

        $dataPerankingan = $dataPerhitungan['dataHasilPerhitungan'];

        usort($dataPerankingan, function ($a, $b) {
            return $b['Nilai_V'] <=> $a['Nilai_V'];
        });

        return view('data-perankingan', [
            'dataPerankingan' => $dataPerankingan
        ]);
    }

    public function getDataInfo(){
        $dataKriteria = Kriteria::all();
        $dataFuzzy = Fuzzy::all();
        $dataAlternatif = Alternatif::all();

        return view('dashboard', [
            'dataKriteria' => $dataKriteria,
            'dataFuzzy' => $dataFuzzy,
            'dataAlternatif' => $dataAlternatif
        ]);
    }
}
