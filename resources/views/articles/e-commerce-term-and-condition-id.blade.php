@extends('layouts.master')
@section('title')
    E-Commerce Terms & Condition
@endsection
@section('css')
    <style>
        .indent-1 {
            padding-left: 56px !important;
        }

        .indent-2 {
            padding-left: 104px !important;
        }

        @media (max-width: 767.98px) {
            .lagramma-h1 {
                font-size: 0.875rem !important;
                border-bottom: 1px solid #000;
            }

            .lagramma-p,
            .lagramma-h2 {
                font-size: 1.25rem !important;
            }

            .lagramma-p {
                padding-bottom: 0.75rem !important;
            }

            .lagramma-h2 {
                padding-bottom: 0.5rem !important;
            }

            .lagramma-green-font {
                font-size: 1.25rem !important;
            }

            .indent-1 {
                padding-left: 1.75rem !important;
            }

            .indent-2 {
                padding-left: 4rem !important;
            }
        }
    </style>
@endsection
@section('content')
    <div class="container container-1440">
        <h1 class="lagramma-h1 pb-5 mt-5">Syarat & Ketentuan E-Commerce</h1>

        <p class="lagramma-p" style="font-weight: 500;">La Gramma sangat bangga dalam menyiapkan dan mengirimkan produk kami
            dengan perawatan dan
            kualitas tertinggi. Setiap pesanan dibuat segar dan dikemas dengan hati-hati untuk memastikan tiba dalam kondisi
            terbaik.</p>

        <p class="lagramma-p" style="font-weight: 500;">Dengan melakukan pemesanan di website kami, Anda menyetujui syarat dan
            ketentuan di bawah ini.</p>

        <h2 class="lagramma-h2">Penyimpanan & Penanganan Produk</h2>
        <p class="lagramma-p" style="font-weight: 500;">Semua produk La Gramma dibuat segar tanpa pengawet.</p>

        <ul class="lagramma-p indent-1">
            <li>Kue dan dessert paling baik dikonsumsi dalam 3–5 hari jika disimpan di lemari pendingin.</li>
            <li>Jangan membekukan kembali produk yang sudah didinginkan atau dibuka.</li>
            <li>Kami tidak bertanggung jawab atas kualitas produk jika instruksi penyimpanan tidak diikuti oleh pelanggan.
            </li>
        </ul>

        <h2 class="lagramma-h2">Pengiriman</h2>
        <ul class="lagramma-p indent-1">
            <li>Pengiriman tersedia di dalam Pontianak dan sekitarnya.</li>
            <li>Jadwal pengiriman tergantung pada ketersediaan kurir dan slot waktu yang dipilih.</li>
            <li>Biaya pengiriman dihitung saat checkout.</li>
        </ul>

        <p class="lagramma-p" style="font-weight: 500;">Setelah pesanan diserahkan kepada kurir, La Gramma tidak bertanggung
            jawab atas:</p>
        <ul class="lagramma-p indent-2">
            <li>Keterlambatan pengiriman akibat kemacetan, cuaca, atau keterlambatan kurir</li>
            <li>Paket yang hilang atau dicuri setelah pengiriman dikonfirmasi</li>
            <li>Alamat yang salah yang diberikan oleh pelanggan</li>
        </ul>
        <p class="lagramma-p" style="font-weight: 500;">Untuk apartemen atau gedung perkantoran, harus ada seseorang yang
            tersedia untuk menerima pesanan.</p>

        <h2 class="lagramma-h2">Verifikasi Pembayaran</h2>
        <ul class="lagramma-p indent-1">
            <li>Pembayaran harus dilakukan secara penuh sebelum pesanan diproses.</li>
            <li>Pelanggan harus mengunggah bukti transfer melalui halaman Konfirmasi Pembayaran.</li>
            <li>Pesanan tanpa bukti pembayaran yang valid tidak akan diproses.</li>
        </ul>

        <h2 class="lagramma-h2">Pembatalan & Perubahan Pesanan</h2>
        <p class="lagramma-p">Tidak ada pembatalan atau perubahan yang dapat dilakukan setelah pembelian dilakukan.</p>

        <h2 class="lagramma-h2">Pengembalian Dana & Penggantian</h2>
        <p class="lagramma-p" style="font-weight: 500;">Karena sifat produk kami yang mudah rusak:</p>
        <ul class="lagramma-p indent-1">
            <li>Tidak ada pengembalian dana atau penukaran setelah pesanan dikonfirmasi.</li>
            <li>Pelanggan harus mengunggah bukti transfer melalui halaman Konfirmasi Pembayaran.</li>
        </ul>

        <p class="lagramma-p" style="font-weight: 500;">Pengembalian dana atau penggantian tidak akan diberikan untuk:</p>
        <ul class="lagramma-p indent-1">
            <li>Alamat atau detail kontak yang salah</li>
            <li>Pelanggan tidak tersedia saat pengiriman</li>
            <li>Keterlambatan pengiriman akibat kurir atau force majeure</li>
            <li>Penyimpanan yang tidak tepat oleh penerima</li>
        </ul>

        <h2 class="lagramma-h2">Kebijakan Musim Ramai</h2>
        <p class="lagramma-p" style="font-weight: 500; padding-bottom: 0px; margin-bottom: 0px;">Selama musim perayaan
            (Ramadan, Lebaran, Natal, Tahun Baru, dll.), volume pesanan dibatasi untuk menjaga kualitas.</p>
        <ul class="lagramma-p indent-1" style="padding-top: 0px;">
            <li>Kami menyarankan untuk memesan minimal 2–3 hari sebelumnya.</li>
            <li>Slot pengiriman dapat ditutup setelah kapasitas terpenuhi.</li>
        </ul>

        <p class="lagramma-h2" style="font-weight: 500;">Batas Pesanan</p>
        <p class="lagramma-p" style="font-weight: 500;">La Gramma dapat membatasi jumlah item per pesanan selama periode
            ramai untuk memastikan kualitas dan keadilan bagi semua pelanggan.</p>

        <p class="lagramma-p mt-4" style="font-weight: 500">Kami dengan senang hati akan membantu dan selalu berusaha
            memberikan pengalaman terbaik untuk Anda.</p>

        <div class="lagramma-green-font mb-5 pb-5" style="font-weight: 500; font-size: 2.3125rem;">
            <a href="/e-commerce-term-and-condition" class="lagramma-green-font">EN</a>
            <span style="margin: 0 0.5rem;">|</span>
            <a href="/e-commerce-term-and-condition-id" class="lagramma-green-font"><u>ID</u></a>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
