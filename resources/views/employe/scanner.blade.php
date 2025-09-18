<x-app-layout>
    <x-slot name="title">
        Scanner QR Code
    </x-slot>

    {{--
        Rappel : La balise meta 'csrf-token' est essentielle pour la sécurité.
        Elle doit être présente dans votre fichier de layout principal (resources/views/layouts/app.blade.php)
        à l'intérieur de la section <head>.
    --}}

    <div class="min-h-screen bg-gray-900 text-white p-4 flex flex-col">
        <header class="text-center mb-4 z-10">
            <h1 class="text-2xl font-bold">Scannez un QR Code</h1>
            <p id="status-text" class="text-gray-400 text-sm animate-pulse">Démarrage de la caméra...</p>
        </header>

        <main class="flex-grow flex flex-col items-center justify-center relative">
            {{-- Le conteneur où la vidéo de la caméra sera injectée --}}
            <div id="reader" class="w-full max-w-md h-auto rounded-lg shadow-2xl overflow-hidden border-4 border-gray-700"></div>

            {{-- Cette zone affichera les messages de succès ou d'erreur par-dessus la vue --}}
            <div id="result" class="absolute inset-0 flex items-center justify-center z-20 transition-opacity duration-300 opacity-0 pointer-events-none"></div>
        </main>

        <footer class="text-center mt-4 z-10">
             <a href="{{ route('employe.dashboard') }}" class="text-sm text-white/80 hover:underline">&larr; Retour au tableau de bord</a>
        </footer>
    </div>

    {{-- Inclusion de la librairie JavaScript pour le scan de QR Code --}}
    <script src="https://unpkg.com/html5-qrcode/html5-qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const html5QrCode = new Html5Qrcode("reader");
            const resultContainer = document.getElementById('result');
            const statusText = document.getElementById('status-text');

            // Fonction pour afficher un message de résultat (succès ou erreur)
            function showResult(message, type = 'success') {
                let icon = '';
                let bgColor = '';

                if (type === 'success') {
                    bgColor = 'bg-green-500/90';
                    icon = `<svg class="w-16 h-16 text-white mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
                } else {
                    bgColor = 'bg-red-500/90';
                    icon = `<svg class="w-16 h-16 text-white mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`;
                }

                resultContainer.innerHTML = `
                    <div class="p-8 rounded-lg ${bgColor} text-white text-center">
                        <div class="flex flex-col items-center">
                            ${icon}
                            <p class="font-semibold text-lg">${message}</p>
                        </div>
                    </div>`;
                resultContainer.classList.remove('opacity-0');
                resultContainer.classList.add('pointer-events-auto');
            }

            // Cette fonction est appelée automatiquement quand un QR code est détecté
            const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                // On arrête la caméra pour ne pas scanner plusieurs fois
                html5QrCode.stop().then(() => {
                    statusText.textContent = "Scan réussi. Traitement en cours...";

                    // On envoie la donnée scannée au serveur
                    fetch('{{ route('pointage.scan') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ scanned_data: decodedText })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showResult(data.message, 'success');
                            // Si le pointage est un succès, on redirige vers le tableau de bord après 2 secondes
                            setTimeout(() => {
                                window.location.href = data.redirect_url;
                            }, 2000);
                        } else {
                            showResult(data.message, 'error');
                            // Si c'est une erreur (ex: déjà pointé), on recharge pour un nouveau scan après 3 secondes
                            setTimeout(() => { location.reload(); }, 3000);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur de communication:', error);
                        showResult('Une erreur de communication est survenue.', 'error');
                        setTimeout(() => { location.reload(); }, 3000);
                    });
                }).catch(err => console.error("Échec de l'arrêt du scanner.", err));
            };

            const config = {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                rememberLastUsedCamera: true,
            };

            // Démarrage du scanner
            html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback)
                .then(() => {
                    statusText.textContent = "Veuillez scanner votre QR code";
                    statusText.classList.remove('animate-pulse');
                })
                .catch(err => {
                    console.error("Erreur de démarrage de la caméra : ", err);
                    statusText.textContent = "Erreur Caméra";
                    showResult("Impossible d'accéder à la caméra. Avez-vous donné la permission ?", 'error');
                });
        });
    </script>
</x-app-layout>