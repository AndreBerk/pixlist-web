<x-guest-layout>
    <div class="min-h-screen bg-slate-900 flex flex-col items-center justify-center p-4 overflow-hidden relative">

        {{-- Header Simples --}}
        <div class="absolute top-0 left-0 w-full p-4 flex justify-between items-center z-10">
            <a href="{{ route('list.public.show', $list) }}" class="text-white bg-white/10 p-2 rounded-full hover:bg-white/20 transition">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <h1 class="text-white font-bold text-xl uppercase tracking-widest opacity-80">Hora da Gravata</h1>
            <div class="w-10"></div> {{-- Espaçador --}}
        </div>

        {{-- A Roleta --}}
        <div class="relative w-[350px] h-[350px] md:w-[500px] md:h-[500px]">
            {{-- Seta Indicadora (Fixa no Topo) --}}
            <div class="absolute top-0 left-1/2 -translate-x-1/2 -mt-6 z-20 drop-shadow-xl filter">
                {{-- Seta desenhada com CSS/SVG para ser bem visível --}}
                <svg width="50" height="60" viewBox="0 0 40 50" fill="none">
                    <path d="M20 50L0 0H40L20 50Z" fill="#ffffff" stroke="#cbd5e1" stroke-width="2"/>
                </svg>
            </div>

            {{-- O Canvas da Roda --}}
            <canvas id="wheel" width="500" height="500" class="w-full h-full transition-transform duration-[5000ms] cubic-bezier(0.2, 0, 0.2, 1)"></canvas>

            {{-- Botão Central (Girar) --}}
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

                {{-- Valor do Resultado --}}
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

            // Dados vindos do Laravel
            const slices = @json($slices);
            const numSlices = slices.length;
            const arcSize = (2 * Math.PI) / numSlices; // Tamanho de cada fatia em radianos
            const degreesPerSlice = 360 / numSlices;   // Tamanho de cada fatia em graus

            let currentRotation = 0; // Armazena a rotação total acumulada

            // Desenhar a Roda
            function drawWheel() {
                const centerX = canvas.width / 2;
                const centerY = canvas.height / 2;
                const radius = canvas.width / 2 - 10;

                slices.forEach((slice, i) => {
                    // Começamos a desenhar do topo (-90 graus ou -PI/2)
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

                    // Texto
                    ctx.save();
                    ctx.translate(centerX, centerY);
                    // Rotaciona para o centro da fatia
                    ctx.rotate(startAngle + arcSize / 2);
                    ctx.textAlign = "right";
                    ctx.fillStyle = "#fff";
                    ctx.font = "bold 24px sans-serif";
                    ctx.shadowColor = "rgba(0,0,0,0.3)";
                    ctx.shadowBlur = 4;
                    ctx.fillText(slice.label, radius - 30, 10);
                    ctx.restore();
                });
            }

            drawWheel();

            // Lógica de Girar (Método Inverso para Precisão)
            spinBtn.addEventListener('click', () => {
                spinBtn.disabled = true;

                // 1. Escolher o vencedor ANTES de girar
                const winnerIndex = Math.floor(Math.random() * numSlices);
                const winner = slices[winnerIndex];

                // 2. Calcular onde esse vencedor está na roda (em graus)
                // O índice 0 está no topo. O índice 1 está à direita, etc.
                // Para o índice X chegar ao topo (onde está a seta), precisamos girar
                // a roda para a esquerda (anti-horário) X fatias.
                // Como o CSS 'rotate(-val)' gira anti-horário, o valor positivo é o índice.

                // Exemplo: 4 fatias. Queremos a fatia 1. Ela está a 90 graus.
                // Precisamos girar 90 graus para ela ir para o topo (0 graus).

                // Adicionamos um pouco de aleatoriedade dentro da própria fatia
                // para não parar sempre no centro exato (entre 10% e 90% da fatia)
                const randomOffset = Math.floor(Math.random() * (degreesPerSlice * 0.8)) - (degreesPerSlice * 0.4);

                // O ângulo alvo para alinhar o índice escolhido com o topo
                const targetAngle = (winnerIndex * degreesPerSlice) + randomOffset;

                // 3. Adicionar voltas completas (Spin)
                // Precisamos garantir que giramos sempre para a frente (acumulativo)
                // A rotação atual pode ser qualquer valor (ex: 7200).
                // Queremos chegar a um múltiplo de 360 + targetAngle.

                const fullSpins = 5 * 360; // 5 voltas

                // Truque matemático para calcular a próxima rotação suave:
                // Pegamos onde estamos, somamos as voltas, e ajustamos o resto para cair no alvo.
                const currentMod = currentRotation % 360;
                let distToTarget = targetAngle - currentMod;

                if (distToTarget < 0) {
                    distToTarget += 360; // Garante que gira para a frente
                }

                const newRotation = currentRotation + fullSpins + distToTarget;
                currentRotation = newRotation;

                // 4. Aplicar a rotação
                // Nota: Usamos negativo no CSS para girar anti-horário, que é o padrão da nossa lógica
                canvas.style.transform = `rotate(-${currentRotation}deg)`;

                // 5. Mostrar resultado quando parar
                setTimeout(() => {
                    resultValue.innerText = winner.label;
                    resultValue.style.color = winner.color;

                    modal.showModal();
                    spinBtn.disabled = false;

                    // Confetti/Festa (Opcional - só log para debug)
                    console.log('Vencedor:', winner.label);

                }, 5000); // 5 segundos (mesmo tempo da transition CSS)
            });
        });
    </script>
    <style>
        .animate-bounce-in { animation: bounceIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); }
        @keyframes bounceIn { 0% { transform: scale(0.5); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
    </style>
</x-guest-layout>
