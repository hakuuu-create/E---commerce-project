<x-filament-panels::page>
    @php
        $d = $this->getKeuanganData();
        $chart = $this->getChartData();
        $label = $d['label'];
        $totalPemasukan   = $d['totalPemasukan'];
        $totalPengeluaran = $d['totalPengeluaran'];
        $saldo            = $d['saldo'];
        $transaksiMasuk   = $d['transaksiMasuk'];
        $transaksiKeluar  = $d['transaksiKeluar'];
        $history          = $d['history'];
    @endphp

    {{-- HEADER FILTER (Tetap dipertahankan dengan sedikit penyesuaian warna) --}}
   

    {{-- SUMMARY CARDS MENGGUNAKAN NATIVE FILAMENT SECTION --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-2">
        {{-- Card Saldo --}}
        <x-filament::section>
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-scale class="w-5 h-5 text-primary-600 dark:text-primary-400" />
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Saldo Bersih</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-white {{ $saldo < 0 ? 'text-danger-600 dark:text-danger-400' : '' }}">
                    {{ $saldo < 0 ? '-' : '' }}Rp {{ number_format(abs($saldo),0,',','.') }}
                </div>
                <div class="text-sm {{ $saldo >= 0 ? 'text-success-600 dark:text-success-400' : 'text-danger-600 dark:text-danger-400' }} font-medium">
                    {{ $saldo >= 0 ? 'Surplus' : 'Defisit' }} Periode Ini
                </div>
            </div>
        </x-filament::section>

        {{-- Card Pemasukan --}}
        <x-filament::section>
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-arrow-trending-up class="w-5 h-5 text-success-600 dark:text-success-400" />
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pemasukan</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-white">
                    Rp {{ number_format($totalPemasukan,0,',','.') }}
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Berdasarkan {{ $transaksiMasuk }} transaksi
                </div>
            </div>
        </x-filament::section>

        {{-- Card Pengeluaran --}}
        <x-filament::section>
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-arrow-trending-down class="w-5 h-5 text-danger-600 dark:text-danger-400" />
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengeluaran</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 dark:text-white">
                    Rp {{ number_format($totalPengeluaran,0,',','.') }}
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Berdasarkan {{ $transaksiKeluar }} transaksi
                </div>
            </div>
        </x-filament::section>
    </div>

    {{-- CHART (Dipertahankan sesuai aslinya) --}}
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-white/10 p-6 mb-2 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-2">
                <x-heroicon-s-chart-bar-square class="w-5 h-5 text-gray-500"/>
                <span class="text-sm font-bold text-gray-800 dark:text-white">Grafik Keuangan</span>
            </div>
            <div class="flex items-center gap-4 text-xs font-semibold">
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span> Pemasukan</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-rose-500 inline-block"></span> Pengeluaran</span>
                <span class="text-gray-400 bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-full">{{ $label }}</span>
            </div>
        </div>
        <canvas id="keuanganChart" style="max-height: 220px;"></canvas>
    </div>

    {{-- TABEL (Dipertahankan, Kolom Sumber & Order Dihapus) --}}
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-white/10 overflow-hidden shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-white/10">
            <div class="flex items-center gap-3">
                <x-heroicon-m-clock class="w-4 h-4 text-gray-400"/>
                <span class="text-sm font-bold text-gray-800 dark:text-white">Riwayat Transaksi</span>
                <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                    {{ $history->count() }} entri
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            @if($history->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                    <x-heroicon-o-folder-open class="w-14 h-14 mb-3 text-gray-300 dark:text-gray-600"/>
                    <p class="text-sm font-medium">Belum ada transaksi pada periode ini.</p>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-white/5">
                            <th class="w-10 px-5 py-3 text-center text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">#</th>
                            <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Tanggal</th>
                            <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Tipe</th>
                            <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Deskripsi</th>
                            <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Kategori</th>
                            <th class="px-5 py-3 text-right text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Nominal</th>
                            <th class="px-5 py-3 text-center text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                        @foreach($history as $i => $t)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                            <td class="px-5 py-4 text-center text-xs font-semibold text-gray-400">{{ $i + 1 }}</td>
                            <td class="px-5 py-4">
                                <div class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($t['tanggal'])->translatedFormat('d M Y') }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($t['tanggal'])->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-5 py-4">
                                @if($t['tipe'] === 'pemasukan')
                                    <span class="inline-flex items-center gap-1 text-xs font-bold px-2 py-1 rounded-md bg-success-50 text-success-700 dark:bg-success-500/10 dark:text-success-400">
                                        <x-heroicon-m-arrow-trending-up class="w-3 h-3"/> Pemasukan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-bold px-2 py-1 rounded-md bg-danger-50 text-danger-700 dark:bg-danger-500/10 dark:text-danger-400">
                                        <x-heroicon-m-arrow-trending-down class="w-3 h-3"/> Pengeluaran
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $t['deskripsi'] }}</div>
                                @if($t['sub_info'] !== '-')
                                    <div class="text-xs text-gray-400 mt-0.5">{{ $t['sub_info'] }}</div>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-xs font-medium text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded-md capitalize">
                                    {{ str_replace('-', ' ', $t['kategori']) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="font-mono font-bold text-sm {{ $t['tipe'] === 'pemasukan' ? 'text-success-600 dark:text-success-400' : 'text-danger-600 dark:text-danger-400' }}">
                                    {{ $t['tipe'] === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($t['nominal'],0,',','.') }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <button wire:click="hapusTransaksi({{ $t['id'] }})"
                                        wire:confirm="Yakin ingin menghapus transaksi ini?"
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-danger-500 hover:bg-danger-50 dark:hover:bg-danger-500/10 transition-colors">
                                    <x-heroicon-m-trash class="w-4 h-4"/>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50 dark:bg-white/5 border-t-2 border-gray-200 dark:border-white/10">
                            <td colspan="5" class="px-5 py-4 text-sm font-bold text-gray-800 dark:text-gray-200">Saldo Bersih Periode Ini</td>
                            <td class="px-5 py-4 text-right">
                                <span class="font-mono font-black text-lg {{ $saldo >= 0 ? 'text-success-600 dark:text-success-400' : 'text-danger-600 dark:text-danger-400' }}">
                                    {{ $saldo < 0 ? '-' : '+' }} Rp {{ number_format(abs($saldo),0,',','.') }}
                                </span>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            @endif
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        (function() {
            const labels      = @json($chart['labels']);
            const pemasukan   = @json($chart['pemasukan']);
            const pengeluaran = @json($chart['pengeluaran']);

            const el = document.getElementById('keuanganChart');
            if (!el) return;
            const ctx = el.getContext('2d');

            const gradMasuk  = ctx.createLinearGradient(0,0,0,220);
            gradMasuk.addColorStop(0,  'rgba(16,185,129,0.25)');
            gradMasuk.addColorStop(1,  'rgba(16,185,129,0.00)');

            const gradKeluar = ctx.createLinearGradient(0,0,0,220);
            gradKeluar.addColorStop(0, 'rgba(239,68,68,0.20)');
            gradKeluar.addColorStop(1, 'rgba(239,68,68,0.00)');

            if (window.__keuanganChart) window.__keuanganChart.destroy();

            window.__keuanganChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [
                        { label: 'Pemasukan', data: pemasukan, borderColor: '#10b981', backgroundColor: gradMasuk, borderWidth: 2.5, pointBackgroundColor: '#10b981', pointBorderColor: '#fff', fill: true, tension: 0.45 },
                        { label: 'Pengeluaran', data: pengeluaran, borderColor: '#ef4444', backgroundColor: gradKeluar, borderWidth: 2, pointBackgroundColor: '#ef4444', pointBorderColor: '#fff', fill: true, tension: 0.45 }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: { intersect: false, mode: 'index' },
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false } },
                        y: {
                            ticks: { callback: val => val >= 1_000_000 ? 'Rp ' + (val/1_000_000).toFixed(1) + 'jt' : (val >= 1_000 ? 'Rp ' + (val/1_000).toFixed(0) + 'rb' : 'Rp ' + val) }
                        }
                    }
                }
            });
        })();
    </script>
    @endpush
</x-filament-panels::page>