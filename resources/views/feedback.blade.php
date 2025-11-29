<x-admin-layout>
    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-6">
        Deixe seu feedback
    </h2>

    <div class="max-w-xl mx-auto bg-white rounded-xl shadow-lg border border-gray-100 p-6 md:p-8">
        @if (session('status') === 'feedback-sent')
            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-6 rounded-lg shadow" role="alert">
                <h3 class="font-bold text-lg mb-2">Obrigado!</h3>
                <p>Recebemos seu feedback. A sua opinião é fundamental para melhorarmos o Pixlist a cada dia.</p>
            </div>
        @elseif($hasSentFeedback)
             <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 text-blue-800 p-6 rounded-lg shadow" role="alert">
                <h3 class="font-bold text-lg mb-2">Feedback recebido!</h3>
                <p>Já recebemos um feedback seu nos últimos 30 dias. Agradecemos novamente pela sua contribuição!</p>
            </div>
        @else
            <form action="{{ route('feedback.store') }}" method="POST">
                @csrf
                <p class="text-gray-600 mb-4">
                    O que você está achando da sua experiência com o Pixlist? Sua opinião é anônima e nos ajuda a melhorar.
                </p>

                {{-- Componente de Estrelas --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Qual sua nota geral? (obrigatório)</label>
                    <div class="flex items-center space-x-1" id="star-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <label for="star-{{ $i }}" class="cursor-pointer group">
                                <input type="radio" name="rating" id="star-{{ $i }}" value="{{ $i }}" class="sr-only" required>
                                <i data-lucide="star" class="w-8 h-8 text-gray-300 group-hover:text-amber-400 star-icon transition"></i>
                            </label>
                        @endfor
                    </div>
                    <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                </div>

                {{-- Campo de Mensagem --}}
                <div class="mb-6">
                     <label for="message" class="block text-sm font-medium text-gray-700">Tem alguma sugestão ou encontrou algum problema? (opcional)</label>
                     <textarea
                        id="message"
                        name="message"
                        rows="5"
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Ex: Adorei a facilidade de criar a lista, mas gostaria de..."
                     >{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="w-full px-6 py-3 bg-emerald-600 text-white font-semibold rounded-lg shadow-md hover:bg-emerald-700 transition">
                    Enviar Feedback
                </button>
            </form>
        @endif
    </div>

    {{-- Script para as estrelas --}}
    <style>
        /* Estilo para a estrela selecionada e as anteriores */
        #star-rating:hover .star-icon,
        #star-rating input:checked ~ label .star-icon,
        #star-rating input:checked + label .star-icon {
            color: #f59e0b; /* amber-500 */
            fill: #f59e0b;
        }

        /* Inverte a ordem do hover para que o "fill" funcione corretamente */
        #star-rating {
            direction: rtl; /* Inverte a direção dos ícones */
        }
        #star-rating label {
            direction: ltr; /* Restaura a direção do texto/ícone individual */
        }
        #star-rating:hover label:hover ~ label .star-icon {
            color: #f59e0b;
            fill: #f59e0b;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();

            const starRating = document.getElementById('star-rating');
            if (starRating) {
                const stars = starRating.querySelectorAll('.star-icon');

                starRating.addEventListener('click', (e) => {
                    const input = e.target.closest('label')?.querySelector('input');
                    if (!input) return;

                    const rating = parseInt(input.value, 10);

                    // Atualiza visualmente
                    stars.forEach((star, index) => {
                        // Invertido por causa do 'direction: rtl'
                        if (index < (5 - rating)) {
                            star.classList.remove('text-amber-400', 'fill-amber-400');
                            star.classList.add('text-gray-300');
                        } else {
                            star.classList.add('text-amber-400', 'fill-amber-400');
                            star.classList.remove('text-gray-300');
                        }
                    });
                });
            }
        });
    </script>
</x-admin-layout>
