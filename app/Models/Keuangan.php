<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangan';

    protected $fillable = [
        'tipe',
        'judul',
        'nominal',
        'sumber',
        'kategori',
        'order_id',
        'keterangan',
    ];

    protected $casts = [
        'nominal' => 'integer',
        
    ];

    // ── Relasi ───────────────────────────────────────────────────────────────

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // ── Scopes ───────────────────────────────────────────────────────────────

    public function scopePemasukan(Builder $q): Builder
    {
        return $q->where('tipe', 'pemasukan');
    }

    public function scopePengeluaran(Builder $q): Builder
    {
        return $q->where('tipe', 'pengeluaran');
    }

    public function scopeDariOrder(Builder $q): Builder
    {
        return $q->where('sumber', 'order');
    }

    public function scopePeriode(Builder $q, $start, $end): Builder
    {
        return $q->whereBetween('created_at', [$start, $end]);
    }

    // ── Helper statis ────────────────────────────────────────────────────────

    /**
     * Panggil ini di PaymentController saat order → status 'paid'.
     */
    public static function catatPemasukanOrder(Order $order): self
    {
        return self::create([
            'tipe'       => 'pemasukan',
            'judul'      => 'Order #' . $order->id . ' – ' . $order->user->name,
            'nominal'    => (int) $order->grand_total,
            'sumber'     => 'order',
            'kategori'   => 'penjualan',
            'order_id'   => $order->id,
            'keterangan' => 'Pembayaran via ' . $order->payment_method,
        ]);
    }
}