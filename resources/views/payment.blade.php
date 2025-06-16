<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran</title>
</head>
<body>
    <h1>Lakukan Pembayaran</h1>

    <button id="pay-button">Bayar Sekarang</button>

    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
            // SnapToken tersedia di variabel `snapToken` yang dilewatkan dari controller
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    /* You may add your own implementation here */
                    alert("Pembayaran berhasil!"); console.log(result);
                },
                onPending: function(result){
                    /* You may add your own implementation here */
                    alert("Pembayaran tertunda!"); console.log(result);
                },
                onError: function(result){
                    /* You may add your own implementation here */
                    alert("Pembayaran gagal!"); console.log(result);
                },
                onClose: function(){
                    /* You may add your own implementation here */
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        };
    </script>
</body>
</html>