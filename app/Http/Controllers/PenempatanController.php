<?php 
 
namespace App\Http\Controllers; 
 
use App\Exports\PenempatanExport;
use App\Models\GuruPamong; 
use App\Models\Mahasiswa; 
use App\Models\Penempatan; 
use App\Models\Sekolah; 
use Illuminate\Http\Request; 
use Maatwebsite\Excel\Facades\Excel;
 
class PenempatanController extends Controller 
{ 
    public function index(Request $request) 
    { 
        $search = $request->input('search'); 
        $status = $request->input('status'); 
 
        $penempatans = Penempatan::with(['mahasiswa.user', 'sekolah', 'guruPamong.user']) 
            ->when($search, function ($query) use ($search) { 
                $query->where(function ($query) use ($search) { 
                    $query->whereHas('mahasiswa.user', function ($query) use ($search) { 
                        $query->where('name', 'like', '%' . $search . '%'); 
                    }) 
                    ->orWhereHas('sekolah', function ($query) use ($search) { 
                        $query->where('nama_sekolah', 'like', '%' . $search . '%'); 
                    }) 
                    ->orWhereHas('guruPamong.user', function ($query) use ($search) { 
                        $query->where('name', 'like', '%' . $search . '%'); 
                    }); 
                }); 
            }) 
            ->when($status && in_array($status, ['menunggu', 'berjalan', 'selesai', 'dibatalkan']), function ($query) use ($status) { 
                $query->where('status', $status); 
            }) 
            ->latest() 
            ->paginate(10) 
            ->withQueryString(); 
 
        return view('admin.penempatan.index', compact('penempatans', 'search', 'status')); 
    }

    public function export(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $namaFile = 'Data_Penempatan_Magang';

        if ($status) {
            $namaFile .= '_' . ucfirst($status);
        }

        if ($search) {
            $namaFile .= '_Pencarian';
        }

        $namaFile .= '.xlsx';

        return Excel::download(
            new PenempatanExport($search, $status),
            $namaFile
        );
    }
 
    public function create() 
    { 
        $mahasiswas = Mahasiswa::with('user')->get(); 
        $sekolahs = Sekolah::where('status', 'aktif')->get(); 
        $guruPamongs = GuruPamong::with('user')->get(); 
 
        return view('admin.penempatan.create', compact('mahasiswas', 'sekolahs', 'guruPamongs')); 
    } 
 
    public function store(Request $request) 
    { 
        $request->validate([ 
            'mahasiswa_id' => 'required|exists:mahasiswas,id', 
            'sekolah_id' => 'required|exists:sekolahs,id', 
            'guru_pamong_id' => 'required|exists:guru_pamongs,id', 
            'periode' => 'required', 
            'tanggal_mulai' => 'required|date', 
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai', 
            'status' => 'required|in:menunggu,berjalan,selesai,dibatalkan', 
        ]); 
 
        $guruPamong = GuruPamong::find($request->guru_pamong_id); 
        if ($guruPamong->sekolah_id != $request->sekolah_id) { 
            return back()->withInput()->withErrors([ 
                'guru_pamong_id' => 'Guru pamong yang dipilih tidak mengajar di sekolah yang dipilih.', 
            ]); 
        } 
 
        Penempatan::create($request->all()); 
 
        return redirect()->route('admin.penempatan.index')->with('success', 'Data penempatan berhasil ditambahkan.'); 
    } 
 
    public function show(Penempatan $penempatan) 
    { 
        return view('admin.penempatan.show', compact('penempatan')); 
    } 
 
    public function edit(Penempatan $penempatan) 
    { 
        $mahasiswas = Mahasiswa::with('user')->get(); 
        $sekolahs = Sekolah::where('status', 'aktif')->get(); 
        $guruPamongs = GuruPamong::with('user')->get(); 
 
        return view('admin.penempatan.edit', compact('penempatan', 'mahasiswas', 'sekolahs', 'guruPamongs')); 
    } 
 
    public function update(Request $request, Penempatan $penempatan) 
    { 
        $request->validate([ 
            'mahasiswa_id' => 'required|exists:mahasiswas,id', 
            'sekolah_id' => 'required|exists:sekolahs,id', 
            'guru_pamong_id' => 'required|exists:guru_pamongs,id', 
            'periode' => 'required', 
            'tanggal_mulai' => 'required|date', 
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai', 
            'status' => 'required|in:menunggu,berjalan,selesai,dibatalkan', 
        ]); 
 
        $guruPamong = GuruPamong::find($request->guru_pamong_id); 
        if ($guruPamong->sekolah_id != $request->sekolah_id) { 
            return back()->withInput()->withErrors([ 
                'guru_pamong_id' => 'Guru pamong yang dipilih tidak mengajar di sekolah yang dipilih.', 
            ]); 
        } 
 
        $penempatan->update($request->all()); 
 
        return redirect()->route('admin.penempatan.index')->with('success', 'Data penempatan berhasil diperbarui.'); 
    } 
 
    public function destroy(Penempatan $penempatan) 
    { 
        $penempatan->delete(); 
 
        return redirect()->route('admin.penempatan.index')->with('success', 'Data penempatan berhasil dihapus.'); 
    } 
}