<?php

namespace App\Http\Controllers;

use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\DB;          //facades DB
use Illuminate\Http\Request;

use App\Imports\DataImport;
use App\Exports\DataExport;
use App\Models\Data;
use App\Models\ZTabel;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Data::all();
        $tittle = "Daftar Data-data";

        return view('data', compact('tittle', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = [
            'required' => 'Skor Harus Diisi',
        ];
        $validasi = $request->validate([
            'skor' => 'required',
        ], $message);
        Data::create($validasi);
        return redirect('data')->with('success', 'Data Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Data::find($id);
        $tittle = "Edit Data";
        return view('edit', compact('tittle', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message = [
            'required' => 'Skor Harus Diisi',
        ];
        $validasi = $request->validate([
            'skor' => 'required',
        ], $message);
        Data::where('id', $id)->update($validasi);
        return redirect('data')->with('success', 'Data Berhasil Diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Data::where('id', $id)->delete();
        return redirect('data')->with('success', 'Data Berhasil Didelete!');
    }

    public function frekuensi()
    {
        $tittle = "Tabel Frekuensi";
        //untuk tabel frekuensi
        $frekuensi = Data::select('skor', DB::raw('count(*) as frekuensi'))
            ->groupBy('skor')
            ->get();

        $totalfrekuensi = Data::count('skor');

        return view('frekuensi', compact('tittle'), [ //menampilkan frekuensi.blade
            'frekuensi' => $frekuensi,
            'totalfrekuensi' => $totalfrekuensi,
        ]);
    }

    public function statistik()
    {
        $tittle = "Tabel Statistik";
        $maxSkor = Data::max('skor');
        $minSkor = Data::min('skor');
        $rata2 = number_format(Data::average('skor'), 2);
        $totalskor = Data::sum('skor');

        return view('statistik', compact('tittle'), [
            'max' => $maxSkor,
            'min' => $minSkor,
            'rata2' => $rata2,
            'totalskor' => $totalskor
        ]);
    }

    public function dataExport()
    {
        return Excel::download(new DataExport, 'data.xlsx');
    }

    public function dataImport(Request $request)
    {
        $file = $request->file('file');
        $namaFile = $file->getClientOriginalName();
        $file->move('Skor', $namaFile);

        $filexcel = Excel::import(new DataImport, public_path('/Skor/' . $namaFile));

        return redirect('data')->withStatus('Excel Berhasil diunggah!');
    }

    public function dataBergolong()
    {
        $tittle = "Data Bergolong";
        $maxSkor = Data::max('skor');
        $minSkor = Data::min('skor');
        $n = Data::count('skor');
        //mencari rentangan
        $rentangan = $maxSkor - $minSkor;

        //mencari kelas        
        $kelas = ceil(1 + 3.3 * log10($n));

        //menghitung interval
        $interval = ceil($rentangan / $kelas);

        //set batas bawah dan batas atas
        $batasBawah = $minSkor;
        $batasAtas = 0;

        //data bergolong
        for ($i = 0; $i < $kelas; $i++) {
            $batasAtas = $batasBawah + $interval - 1;
            $frekuensi[$i] = Data::select(DB::raw('count(*) as frekuensi, skor'))
                ->where([
                    ['skor', '>=', $batasBawah],
                    ['skor', '<=', $batasAtas],
                ])
                ->groupBy()
                ->count();
            $data[$i] = $batasBawah . " - " . $batasAtas;
            $batasBawah = $batasAtas + 1;
        }


        return view('databergolong', compact('tittle'), [
            'data' => $data,
            'frekuensi' => $frekuensi,
            'batasAtas' => $batasAtas,
            'batasBawah' => $batasBawah,
            'kelas' => $kelas,
            'interval' => $interval,
            'rentangan' => $rentangan,
        ]);
    }
    public function chiKuadrat()
    {

        $tittle = "Chi Kuadrat";
        $maxSkor = Data::max('skor');
        $minSkor = Data::min('skor');
        //$n = f0 = banyak skor/total frekuensi
        $n = Data::count('skor');
        $rata2 = number_format(Data::average('skor'), 2);

        //function standar deviasi
        function std_deviation($my_arr)
        {
            $no_element = count($my_arr);
            $var = 0.0;
            $avg = array_sum($my_arr) / $no_element;
            foreach ($my_arr as $i) {
                $var += pow(($i - $avg), 2);
            }
            return (float)sqrt($var / $no_element);
        }

        //function desimal
        function desimal($nilai)
        {
            if ($nilai < 0) {
                $des = substr($nilai, 0, 4);
            } else {
                $des = substr($nilai, 0, 3);
            }
            return $des;
        }

        //function label
        function label($nilai)
        {
            if ($nilai < 0) {
                $str1 = substr($nilai, 4, 1);
            } else {
                $str1 = substr($nilai, 3, 1);
            }

            switch ($str1) {
                case '0':
                    $sLabel = 'nol';
                    break;
                case '1':
                    $sLabel = 'satu';
                    break;
                case '2':
                    $sLabel = 'dua';
                    break;
                case '3':
                    $sLabel = 'tiga';
                    break;
                case '4':
                    $sLabel = 'empat';
                    break;
                case '5':
                    $sLabel = 'lima';
                    break;
                case '6':
                    $sLabel = 'enam';
                    break;
                case '7':
                    $sLabel = 'tujuh';
                    break;
                case '8':
                    $sLabel = 'delapan';
                    break;
                case '9':
                    $sLabel = 'sembilan';
                    break;
                default:
                    $sLabel = 'Tidak ada field';
            }

            return $sLabel;
        }

        //ambil nilai skor
        $Data = Data::select('skor')->get();

        //masukin skor ke dalam array biar bsa dipakek sama functionnya
        $i = 0;
        foreach ($Data as $a) {
            $arraySkor[$i] = $a->skor;
            $i++;
        }

        //standar deviasi dari seluruh skor
        $SD = number_format(std_deviation($arraySkor), 2);

        //mencari rentangan
        $rentangan = $maxSkor - $minSkor;

        //mencari kelas        
        $kelas = ceil(1 + 3.3 * log10($n));

        //menghitung interval
        $interval = ceil($rentangan / $kelas);

        //set batas bawah dan batas atas
        $batasBawah = $minSkor;
        $batasAtas = 0;

        //data chi
        $totalchi = 0;
        for ($i = 0; $i < $kelas; $i++) {
            //menghitung batas bawah
            $batasBawahBaru[$i] = $batasBawah - 0.5;

            $batasAtas = $batasBawah + $interval - 1;

            //menghitung batas atas
            $batasAtasBaru[$i] = $batasAtas + 0.5;

            //menghitung atas dan bawah z
            $zBawah[$i] = number_format(($batasBawahBaru[$i] - $rata2) / $SD, 2);
            $zAtas[$i] = number_format(($batasAtasBaru[$i] - $rata2) / $SD, 2);

            //menghitung z tabel atas dan bawah
            $cariDesimalBawah = desimal($zBawah[$i]);
            $cariDesimalAtas = desimal($zAtas[$i]);

            $labelDesimalBawah = label($zBawah[$i]);
            $labelDesimalAtas = label($zAtas[$i]);

            $zTabelBawah = ZTabel::where('z', '=', $cariDesimalBawah)->get();
            $zTabelAtas = ZTabel::where('z', '=', $cariDesimalAtas)->get();
            $zTabelBawahFix[$i] = $zTabelBawah[0]->$labelDesimalBawah;
            $zTabelAtasFix[$i] = $zTabelAtas[0]->$labelDesimalAtas;

            //menghitung l/proporsi
            $lprop[$i] = abs($zTabelBawahFix[$i] - $zTabelAtasFix[$i]);

            //menghitung fe(L*N)
            $fe[$i] = $lprop[$i] * $n;

            //menghitung f0
            $frekuensi[$i] = Data::select(DB::raw('count(*) as frekuensi, skor'))
                ->where([
                    ['skor', '>=', $batasBawah],
                    ['skor', '<=', $batasAtas],
                ])
                ->groupBy()
                ->count();
            $data[$i] = $batasBawah . " - " . $batasAtas;
            $batasBawah = $batasAtas + 1;

            //menghitung (f0-fe)^2/fe
            $kai[$i] = number_format(pow(($frekuensi[$i] - $fe[$i]), 2) / $fe[$i], 7);
            $totalchi += $kai[$i];
        }



        return view('chi', compact('tittle'), [
            'data' => $data,
            'frekuensi' => $frekuensi,
            'batasAtas' => $batasAtas,
            'batasBawah' => $batasBawah,
            'kelas' => $kelas,
            'interval' => $interval,
            'rentangan' => $rentangan,
            'batasBawahBaru' => $batasBawahBaru,
            'batasAtasBaru' => $batasAtasBaru,
            'zBawah' => $zBawah,
            'zAtas' => $zAtas,
            'zTabelBawahFix' => $zTabelBawahFix,
            'zTabelAtasFix' => $zTabelAtasFix,
            'lprop' => $lprop,
            'fe' => $fe,
            'kai' => $kai,
            'totalchi' => $totalchi,
        ]);
    }

    public function lilliefors()
    {
        $tittle = "Lilliefors";
        //ngambil banyak skor
        $n = Data::count('skor');
        $rata2 = number_format(Data::average('skor'), 2);

        //function standar deviasi
        function std_deviation($my_arr)
        {
            $no_element = count($my_arr);
            $var = 0.0;
            $avg = array_sum($my_arr) / $no_element;
            foreach ($my_arr as $i) {
                $var += pow(($i - $avg), 2);
            }
            return (float)sqrt($var / $no_element);
        }

        //function desimal
        function desimal($nilai)
        {
            if ($nilai < 0) {
                $des = substr($nilai, 0, 4);
            } else {
                $des = substr($nilai, 0, 3);
            }
            return $des;
        }

        //function label
        function label($nilai)
        {
            if ($nilai < 0) {
                $str1 = substr($nilai, 4, 1);
            } else {
                $str1 = substr($nilai, 3, 1);
            }

            switch ($str1) {
                case '0':
                    $sLabel = 'nol';
                    break;
                case '1':
                    $sLabel = 'satu';
                    break;
                case '2':
                    $sLabel = 'dua';
                    break;
                case '3':
                    $sLabel = 'tiga';
                    break;
                case '4':
                    $sLabel = 'empat';
                    break;
                case '5':
                    $sLabel = 'lima';
                    break;
                case '6':
                    $sLabel = 'enam';
                    break;
                case '7':
                    $sLabel = 'tujuh';
                    break;
                case '8':
                    $sLabel = 'delapan';
                    break;
                case '9':
                    $sLabel = 'sembilan';
                    break;
                default:
                    $sLabel = 'Tidak ada field';
            }

            return $sLabel;
        }

        //ambil nilai skor
        $Data = Data::select('skor')->get();

        //masukin skor ke dalam array biar bsa dipakek sama functionnya
        $i = 0;
        foreach ($Data as $a) {
            $arraySkor[$i] = $a->skor;
            $i++;
        }

        //standar deviasi dari seluruh skor
        $SD = number_format(std_deviation($arraySkor), 2);

        //ngambil data dan frekuensinya
        for ($i = 0; $i < $n; $i++) {
            $frekuensi[$i] = Data::select('skor', DB::raw('count(*) as frekuensi'))  //ambil skor, hitung banyak skor taruh di tabel frekuensi
                ->groupBy('skor')    //urutkan sesuai skor
                ->get();
            //ngambil banyak data setelah diambil frekuensinya     
            $banyakData = count($frekuensi[$i]);
        }

        //mencari f(zi) dari tabel z
        $fkum = 0;
        $totalLillie = 0;
        for ($i = 0; $i < $banyakData; $i++) {

            //frekuensi komulatif
            $fkum += $frekuensi[0][$i]->frekuensi;
            $fkum2[$i] = $fkum;

            //mencari nilai Zi
            $Zi[$i] = number_format(($frekuensi[0][$i]->skor - $rata2) / $SD, 2);

            //mencari F(zi)dari tabel z
            $cariDesimalZi = desimal($Zi[$i]);
            $labelZi = label($Zi[$i]);
            $zTabel = ZTabel::where('z', '=', $cariDesimalZi)->get();
            $fZi[$i] = $zTabel[0]->$labelZi;

            //mencari S(Zi)
            $sZi[$i] = $fkum2[$i] / $n;

            //mencari |F(Zi)-S(Zi)|
            $lilliefors[$i] = abs($fZi[$i] - $sZi[$i]);

            //total
            $totalLillie += $lilliefors[$i];
        }


        return view('/lilliefors', compact('tittle'), [
            'frekuensi' => $frekuensi,
            'banyakData' => $banyakData,
            'fkum2' => $fkum2,
            'Zi' => $Zi,
            'fZi' => $fZi,
            'sZi' => $sZi,
            'lilliefors' => $lilliefors,
            'totalLillie' => $totalLillie,
            'n' => $n,
        ]);
    }
}
