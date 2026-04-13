<?php

namespace App\Filament\Pages;

use App\Models\Keuangan;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class KeuanganPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Keuangan';
    protected static ?string $title = 'Manajemen Keuangan';
    protected static ?int $navigationSort = 5;

    protected static string $view = 'filament.pages.keuangan-page';

    // ── State filter ─────────────────────────────────────────────────────────
    public string $periode  = 'bulanan';
    public int    $tahun;
    public int    $bulan;
    public int    $minggu   = 1;
    public string $startDate = '';
    public string $endDate   = '';

    // ── State form modal tambah transaksi ─────────────────────────────────────
    public ?array $data = [];

    public function mount(): void
    {
        $this->tahun = now()->year;
        $this->bulan = now()->month;
        $this->form->fill();
    }

    // ── Form (Tambah Transaksi) ───────────────────────────────────────────────
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('tipe')
                    ->label('Tipe Transaksi')
                    ->options(['pemasukan' => 'Pemasukan', 'pengeluaran' => 'Pengeluaran'])
                    ->default('pemasukan')
                    ->required()
                    ->native(false),

                TextInput::make('judul')
                    ->label('Judul Transaksi')
                    ->placeholder('cth: Modal Awal, Gaji, dsb.')
                    ->required()
                    ->maxLength(255),

                TextInput::make('nominal')
                    ->label('Nominal (Rp)')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->prefix('Rp'),

                Select::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'penjualan'        => 'Penjualan',
                        'operasional'      => 'Operasional',
                        'stok-produk'      => 'Stok / Produk',
                        'gaji'             => 'Gaji',
                        'pemasukan-lain'   => 'Pemasukan Lain',
                        'pengeluaran-lain' => 'Pengeluaran Lain',
                    ])
                    ->searchable()
                    ->nullable()
                    ->native(false),

                Textarea::make('keterangan')
                    ->label('Keterangan (opsional)')
                    ->placeholder('Catatan tambahan...')
                    ->rows(2)
                    ->maxLength(500),
            ])
            ->statePath('data');
    }

    protected function getTransaksiFormSchema(): array
{
    return [
        Select::make('tipe')
            ->label('Tipe Transaksi')
            ->options(['pemasukan' => 'Pemasukan', 'pengeluaran' => 'Pengeluaran'])
            ->default('pemasukan')
            ->required()
            ->native(false),

        TextInput::make('judul')
            ->label('Judul Transaksi')
            ->required(),

        TextInput::make('nominal')
            ->label('Nominal (Rp)')
            ->numeric()
            ->required()
            ->prefix('Rp'),

        Select::make('kategori')
            ->label('Kategori')
            ->options([
                'penjualan' => 'Penjualan',
                'operasional' => 'Operasional',
                'pemasukan-lain' => 'Pemasukan Lain',
                'pengeluaran-lain' => 'Pengeluaran Lain',
            ])
            ->native(false),

        Textarea::make('keterangan')
            ->label('Keterangan')
            ->rows(2),
    ];
}

    // ── Actions ──────────────────────────────────────────────────────────────
    protected function getHeaderActions(): array
{
    return [
        Action::make('tambahTransaksi')
            ->label('Tambah Transaksi')
            ->icon('heroicon-o-plus-circle')
            ->color('primary')
            // Gunakan skema helper di sini
            ->form($this->getTransaksiFormSchema()) 
            ->action(function (array $data): void {
                \App\Models\Keuangan::create([
                    'tipe'       => $data['tipe'],
                    'judul'      => $data['judul'],
                    'nominal'    => (int) $data['nominal'],
                    'kategori'   => $data['kategori'] ?? 'lain-lain',
                    'keterangan' => $data['keterangan'] ?? null,
                    'sumber'     => 'manual',
                ]);

                Notification::make()
                    ->title('Transaksi berhasil ditambahkan!')
                    ->success()
                    ->send();
            }),
    ];
}

    // ── Computed data yang dipakai view ──────────────────────────────────────
    public function getKeuanganData(): array
    {
        $now = Carbon::now();
        [$startDate, $endDate, $label] = $this->getPeriode($now);

        $base = Keuangan::periode($startDate, $endDate);

        $totalPemasukan   = (clone $base)->pemasukan()->sum('nominal');
        $totalPengeluaran = (clone $base)->pengeluaran()->sum('nominal');
        $saldo            = $totalPemasukan - $totalPengeluaran;

        $transaksiMasuk  = (clone $base)->pemasukan()->count();
        $transaksiKeluar = (clone $base)->pengeluaran()->count();

        $history = (clone $base)
            ->orderByDesc('created_at')
            ->get()
            ->map(fn($item) => [
                'id'        => $item->id,
                'tanggal'   => $item->created_at,
                'tipe'      => $item->tipe,
                'deskripsi' => $item->judul,
                'sub_info'  => $item->keterangan ?? '-',
                'kategori'  => $item->kategori ?? '-',
                'nominal'   => $item->nominal,
            ]);

        return compact(
            'label',
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'transaksiMasuk',
            'transaksiKeluar',
            'history',
        );
    }

    public function getChartData(): array
    {
        $now    = Carbon::now();
        $labels = [];
        $masuk  = [];
        $keluar = [];

        $tahun = $this->tahun;
        $bulan = $this->bulan;

        switch ($this->periode) {
            case 'mingguan':
                $start = Carbon::now()->startOfWeek(Carbon::MONDAY);
                for ($i = 0; $i < 7; $i++) {
                    $hari     = $start->copy()->addDays($i);
                    $labels[] = $hari->translatedFormat('D');
                    $masuk[]  = Keuangan::pemasukan()->whereDate('created_at', $hari)->sum('nominal');
                    $keluar[] = Keuangan::pengeluaran()->whereDate('created_at', $hari)->sum('nominal');
                }
                break;

            case 'tahunan':
                for ($i = 1; $i <= 12; $i++) {
                    $labels[] = Carbon::create($tahun, $i, 1)->translatedFormat('M');
                    $masuk[]  = Keuangan::pemasukan()->whereYear('created_at', $tahun)->whereMonth('created_at', $i)->sum('nominal');
                    $keluar[] = Keuangan::pengeluaran()->whereYear('created_at', $tahun)->whereMonth('created_at', $i)->sum('nominal');
                }
                break;

            case 'bulanan':
            default:
                $startMonth = Carbon::create($tahun, $bulan, 1)->startOfMonth();
                $endMonth   = $startMonth->copy()->endOfMonth();
                $current    = $startMonth->copy();
                $week       = 1;

                while ($current->lte($endMonth)) {
                    $weekEnd = $current->copy()->endOfWeek(Carbon::SUNDAY);
                    if ($weekEnd->gt($endMonth)) $weekEnd = $endMonth->copy();

                    $labels[] = 'W' . $week;
                    $masuk[]  = Keuangan::pemasukan()->whereBetween('created_at', [$current->copy()->startOfDay(), $weekEnd->copy()->endOfDay()])->sum('nominal');
                    $keluar[] = Keuangan::pengeluaran()->whereBetween('created_at', [$current->copy()->startOfDay(), $weekEnd->copy()->endOfDay()])->sum('nominal');

                    $current = $weekEnd->copy()->addDay();
                    $week++;
                }
                break;
        }

        return ['labels' => $labels, 'pemasukan' => $masuk, 'pengeluaran' => $keluar];
    }

    // ── Aksi hapus transaksi ─────────────────────────────────────────────────
    public function hapusTransaksi(int $id): void
    {
        $t = Keuangan::findOrFail($id);
        $t->delete();
        
        Notification::make()->title('Transaksi berhasil dihapus.')->success()->send();
    }

    public function setPeriode(string $p): void
    {
        $this->periode = $p;
    }

    private function getPeriode(Carbon $now): array
    {
        switch ($this->periode) {
            case 'mingguan':
                $startOfMonth = Carbon::create($this->tahun, $this->bulan, 1)->startOfMonth();
                $start        = $startOfMonth->copy()->addWeeks($this->minggu - 1)->startOfWeek(Carbon::MONDAY);
                $end          = $start->copy()->endOfWeek(Carbon::SUNDAY);
                $label        = "Minggu ke-{$this->minggu}, " . $startOfMonth->translatedFormat('F Y');
                break;

            case 'tahunan':
                $start = Carbon::create($this->tahun, 1, 1)->startOfYear();
                $end   = $start->copy()->endOfYear();
                $label = "Tahun {$this->tahun}";
                break;

            case 'bulanan':
            default:
                $start = Carbon::create($this->tahun, $this->bulan, 1)->startOfMonth();
                $end   = $start->copy()->endOfMonth();
                $label = $start->translatedFormat('F Y');
                break;
        }

        return [$start, $end, $label];
    }
}