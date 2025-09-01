<x-app-layout>
    <x-slot name="title">
        Scanner QR Code
    </x-slot>

    <div class="min-h-screen bg-background text-foreground p-4 flex flex-col">
        <header class="text-center mb-4">
            <h1 class="text-xl font-bold">Scannez un QR Code</h1>
            <p class="text-muted-foreground text-sm">Placez le code QR dans le cadre</p>
        </header>

        <main class="flex-grow flex flex-col items-center justify-center">
            <!-- Conteneur pour le scanner -->
            <div id="qr-reader" class="w-full max-w-sm mx-auto rounded-lg overflow-hidden border-2 border-gray-300 shadow-lg"></div>

            <!-- Zone de message pour les résultats -->
            <div id="qr-result" class="mt-4 text-center w-full max-w-sm mx-auto"></div>
        </main>

        <footer class="text-center mt-6">
             <a href="{{ route('employe.dashboard') }}" class="text-sm text-primary hover:underline">&larr; Retour au tableau de bord</a>
        </footer>
    </div>

    <!-- Librairie pour le scanner QR -->
    <script src="[https://unpkg.com/html5-qrcode](https://unpkg.com/html5-qrcode)"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const resultContainer = document.getElementById('qr-result');
            let isProcessing = false; // Verrou pour éviter les scans multiples

            function onScanSuccess(decodedText, decodedResult) {
                if (isProcessing) {
                    return; // Ignorer si un scan est déjà en cours de traitement
                }
                isProcessing = true;

                // Vibreur pour le feedback utilisateur
                if (navigator.vibrate) {
                    navigator.vibrate(100);
                }

                // Afficher un message de traitement
                resultContainer.innerHTML = `<p class="text-blue-600 font-semibold animate-pulse">Traitement en cours...</p>`;

                // Envoyer le résultat au serveur
                fetch("{{ route('pointage.scan') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ scan_result: decodedText })
                })
                .then(response => {
                    // On a besoin du corps de la réponse pour les erreurs et les succès
                    return response.json().then(data => ({ status: response.status, body: data }));
                })
                .then(({ status, body }) => {
                    if (status >= 200 && status < 300) { // Succès (ex: 200 OK)
                        const user = body.user;
                        const pointage = body.pointage;
                        let messageHtml = `
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md">
                                <p class="font-bold">${body.message}</p>
                                <p class="text-sm mt-1">${user.prenom} ${user.nom}</p>
                                <div class="text-xs mt-2">
                                    <p>Arrivée: <strong>${pointage.heure_arrivee || '--:--'}</strong></p>
                                    <p>Départ: <strong>${pointage.heure_depart || '--:--'}</strong></p>
                                </div>
                            </div>
                        `;
                        resultContainer.innerHTML = messageHtml;
                        // Rediriger vers le tableau de bord après 3 secondes
                        setTimeout(() => window.location.href = "{{ route('employe.dashboard') }}", 3000);
                    } else { // Erreur (ex: 409 Conflict, 400 Bad Request)
                        throw new Error(body.message || 'Une erreur est survenue.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    resultContainer.innerHTML = `
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md">
                            <p class="font-bold">Opération échouée</p>
                            <p class="text-sm mt-1">${error.message}</p>
                        </div>
                    `;
                    // Réinitialiser le verrou après 3 secondes pour permettre un nouveau scan
                    setTimeout(() => { isProcessing = false; }, 3000);
                });
            }

            const html5Qrcode = new Html5Qrcode("qr-reader");
            html5Qrcode.start(
                { facingMode: "environment" }, // Utiliser la caméra arrière par défaut
                {
                    fps: 10,
                    qrbox: (viewfinderWidth, viewfinderHeight) => {
                        const minEdge = Math.min(viewfinderWidth, viewfinderHeight);
                        const qrboxSize = Math.floor(minEdge * 0.7);
                        return { width: qrboxSize, height: qrboxSize };
                    }
                },
                onScanSuccess,
                (errorMessage) => { /* Ignorer les erreurs de scan non bloquantes */ }
            ).catch(err => {
                 resultContainer.innerHTML = `
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                        <p class="font-bold">Erreur de caméra</p>
                        <p class="text-sm mt-1">Impossible de démarrer la caméra. Veuillez autoriser l'accès dans les paramètres de votre navigateur.</p>
                    </div>
                `;
            });
        });
    </script>
</x-app-layout>