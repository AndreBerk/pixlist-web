<x-guest-layout>
    <div class="min-h-screen bg-slate-900 flex flex-col items-center justify-center p-4 overflow-hidden relative">

        {{-- Header --}}
        <div class="absolute top-0 left-0 w-full p-4 flex justify-between items-center z-10">
            <a href="{{ route('list.public.show', $list) }}" class="text-white bg-white/10 p-2 rounded-full hover:bg-white/20 transition">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <h1 class="text-white font-bold text-xl uppercase tracking-widest opacity-80">Hora da Gravata</h1>
            <div class="w-10"></div>
        </div>

        {{-- A Roleta --}}
        <div class="relative w-[350px] h-[350px] md:w-[500px] md:h-[500px]">
            {{-- Seta Indicadora --}}
            <div class="absolute top-0 left-1/2 -translate-x-1/2 -mt-5 z-20 drop-shadow-xl filter">
                <svg width="50" height="60" viewBox="0 0 40 50" fill="none">
                    <path d="M20 50L0 0H40L20 50Z" fill="#ffffff" stroke="#cbd5e1" stroke-width="2"/>
                </svg>
            </div>

            {{-- Canvas --}}
            <canvas id="wheel" width="500" height="500" class="w-full h-full transition-transform duration-[5000ms] cubic-bezier(0.25, 0.1, 0.25, 1)"></canvas>

            {{-- Botão Central --}}
            <button id="spinBtn" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-20 h-20 bg-white rounded-full shadow-[0_0_30px_rgba(0,0,0,0.5)] flex items-center justify-center border-4 border-slate-200 hover:scale-105 active:scale-95 transition z-10 text-emerald-600 font-extrabold uppercase tracking-wide text-sm">
                Girar
            </button>
        </div>

        {{-- Modal de Resultado --}}
        <dialog id="resultModal" class="rounded-3xl p-8 bg-white shadow-2xl backdrop:bg-black/80 text-center max-w-sm w-full open:animate-bounce-in">
            <div class="flex flex-col items-center">
                <div class="mb-4 p-4 bg-emerald-100 rounded-full">
                    <i data-lucide="party-popper" class="w-12 h-12 text-emerald-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800">Caiu em...</h3>
                <p id="resultValue" class="text-5xl font-extrabold text-emerald-600 my-4 tracking-tight">R$ 0,00</p>
                <p class="text-gray-500 text-sm mb-6 px-4">
                    Obrigado por participar! Use o PIX ou a maquininha para pagar agora.
                </p>
                <form method="dialog">
                    <button class="w-full py-3.5 bg-gray-900 text-white font-bold rounded-xl hover:bg-black transition shadow-lg">
                        Girar de Novo
                    </button>
                </form>
            </div>
        </dialog>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if(window.lucide) window.lucide.createIcons();

            const canvas = document.getElementById('wheel');
            const ctx = canvas.getContext('2d');
            const spinBtn = document.getElementById('spinBtn');
            const modal = document.getElementById('resultModal');
            const resultValue = document.getElementById('resultValue');

            // CORREÇÃO 1: Object.values garante que seja um array, mesmo se o PHP enviar um Objeto
            const slices = Object.values(@json($slices));

            const numSlices = slices.length;
            const arcSize = (2 * Math.PI) / numSlices;
            const degreesPerSlice = 360 / numSlices;

            let currentRotation = 0;

            function drawWheel() {
                const centerX = canvas.width / 2;
                const centerY = canvas.height / 2;
                const radius = canvas.width / 2 - 10;

                ctx.clearRect(0, 0, canvas.width, canvas.height);

                slices.forEach((slice, i) => {
                    const startAngle = i * arcSize - (Math.PI / 2);
                    const endAngle = startAngle + arcSize;

                    ctx.beginPath();
                    ctx.moveTo(centerX, centerY);
                    ctx.arc(centerX, centerY, radius, startAngle, endAngle);
                    ctx.fillStyle = slice.color;
                    ctx.fill();
                    ctx.lineWidth = 2;
                    ctx.strokeStyle = "#ffffff";
                    ctx.stroke();

                    ctx.save();
                    ctx.translate(centerX, centerY);
                    ctx.rotate(startAngle + arcSize / 2);
                    ctx.textAlign = "right";
                    ctx.fillStyle = "#fff";
                    ctx.font = "bold 24px sans-serif";
                    ctx.shadowColor = "rgba(0,0,0,0.5)";
                    ctx.shadowBlur = 4;
                    ctx.fillText(slice.label, radius - 30, 10);
                    ctx.restore();
                });
            }

            // Desenha a roleta inicialmente
            if(numSlices > 0) {
                drawWheel();
            } else {
                alert("Configure as fatias no painel administrativo!");
            }

            spinBtn.addEventListener('click', () => {
                if(numSlices === 0) return;

                spinBtn.disabled = true;

                // 1. Escolher o vencedor
                const winnerIndex = Math.floor(Math.random() * numSlices);
                const winner = slices[winnerIndex];

                // CORREÇÃO 2: Cálculo preciso do ângulo
                // Queremos o CENTRO da fatia, não o início.
                // startAngle = winnerIndex * degreesPerSlice
                // centerAngle = startAngle + (degreesPerSlice / 2)
                const sliceCenterAngle = (winnerIndex * degreesPerSlice) + (degreesPerSlice / 2);

                // Adiciona aleatoriedade (Jitter), mas respeitando as bordas
                // Deixa uma margem de segurança de 10% de cada lado para não cair na linha
                const safetyMargin = degreesPerSlice * 0.1;
                const maxJitter = (degreesPerSlice / 2) - safetyMargin;
                // Random entre -maxJitter e +maxJitter
                const randomOffset = (Math.random() * maxJitter * 2) - maxJitter;

                // O ângulo alvo final para alinhar com o TOPO (0 graus visualmente)
                const targetAngle = sliceCenterAngle + randomOffset;

                // Configura as voltas
                const fullSpins = 5 * 360;

                // Matemática para calcular a rotação acumulativa (sempre gira pra frente)
                const currentMod = currentRotation % 360;
                let distToTarget = targetAngle - currentMod;

                // Normaliza para garantir rotação positiva
                if (distToTarget < 0) {
                    distToTarget += 360;
                }

                const newRotation = currentRotation + fullSpins + distToTarget;
                currentRotation = newRotation;

                // Aplica a rotação (Negativo para girar anti-horário, trazendo a fatia da direita para o topo)
                canvas.style.transform = `rotate(-${currentRotation}deg)`;

                setTimeout(() => {
                    resultValue.innerText = winner.label;
                    // Ajusta cor do texto para combinar (ou preto se for muito claro)
                    resultValue.style.color = winner.color;
                    modal.showModal();
                    spinBtn.disabled = false;
                }, 5000);
            });
        });
    </script>
    <style>
        .animate-bounce-in { animation: bounceIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); }
        @keyframes bounceIn { 0% { transform: scale(0.5); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
    </style>
</x-guest-layout>
