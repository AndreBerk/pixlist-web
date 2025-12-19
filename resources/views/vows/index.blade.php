<x-admin-layout title="Meus Votos">
    <div class="mb-8">
        <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">Meus Votos</h2>
        <p class="text-gray-500 dark:text-slate-400 mt-1">Escreva seus votos secretos. Proteja com senha para emocionar no altar.</p>
    </div>

    @php
        // Verifica se é casamento
        $isWedding = stripos($list->event_type, 'casamento') !== false || stripos($list->event_type, 'noivado') !== false;
    @endphp

    @if(!$isWedding)
        <div class="bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-500 p-6 rounded-r-xl transition-colors duration-300">
            <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100">Funcionalidade Exclusiva</h3>
            <p class="text-blue-700 dark:text-blue-300 mt-1">O gerenciamento de votos está disponível apenas para eventos do tipo <strong>Casamento</strong>.</p>
            <a href="{{ route('list.config.edit') }}" class="mt-4 inline-block text-sm font-bold text-blue-600 dark:text-blue-400 hover:underline">Alterar tipo de evento &rarr;</a>
        </div>
    @else

        @if (session('status'))
            <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-lg border border-emerald-200 dark:border-emerald-800 font-bold flex items-center gap-2 animate-fade-in-up">
                <i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('status') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- =========================================================
                 CARD NOIVA
                 ========================================================= --}}
            <div x-data="{
                locked: {{ $list->vows_bride_pin ? 'true' : 'false' }},
                pinInput: '',
                savedPin: '{{ $list->vows_bride_pin }}',
                unlock() {
                    if (this.pinInput === this.savedPin) { this.locked = false; }
                    else { alert('Senha incorreta!'); }
                }
            }" class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-pink-100 dark:border-pink-900/50 overflow-hidden relative transition-colors duration-300 hover:shadow-xl">

                {{-- Header --}}
                <div class="bg-pink-50 dark:bg-pink-900/20 p-6 border-b border-pink-100 dark:border-pink-900/30 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-pink-200 dark:bg-pink-900/50 p-2 rounded-lg text-pink-700 dark:text-pink-300">
                            <i data-lucide="heart" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Votos da Noiva</h3>
                    </div>
                    @if($list->vows_bride)
                        {{-- Botão Imprimir (Link direto para forçar a tela de senha) --}}
                        <a href="{{ route('vows.print', 'bride') }}" target="_blank" class="text-pink-600 dark:text-pink-400 hover:text-pink-800 dark:hover:text-pink-200 transition p-2 hover:bg-pink-100 dark:hover:bg-pink-900/30 rounded-full" title="Imprimir Cartão">
                            <i data-lucide="printer" class="w-5 h-5"></i>
                        </a>
                    @endif
                </div>

                {{-- TELA DE BLOQUEIO --}}
                <div x-show="locked" class="p-8 text-center flex flex-col items-center justify-center min-h-[400px]">
                    <div class="bg-gray-100 dark:bg-slate-700 p-4 rounded-full mb-4">
                        <i data-lucide="lock" class="w-8 h-8 text-gray-400 dark:text-slate-400"></i>
                    </div>
                    <h4 class="font-bold text-gray-700 dark:text-slate-300 mb-2">Conteúdo Protegido</h4>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mb-6">Digite o PIN para ler ou editar.</p>

                    <div class="flex gap-2 justify-center mb-6">
                        <input type="password" x-model="pinInput" placeholder="PIN" maxlength="4" class="w-24 text-center text-lg font-bold tracking-widest rounded-lg border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-pink-500 focus:border-pink-500 outline-none transition-colors">
                        <button @click="unlock()" class="px-4 py-2 bg-pink-600 dark:bg-pink-700 text-white font-bold rounded-lg hover:bg-pink-700 dark:hover:bg-pink-600 transition">
                            Abrir
                        </button>
                    </div>

                    {{-- BOTÃO ESQUECI A SENHA --}}
                    <button type="button" onclick="recoverPin('bride', this)" class="text-xs text-pink-500 dark:text-pink-400 hover:text-pink-700 dark:hover:text-pink-300 font-semibold underline underline-offset-2 transition mb-6">
                        Esqueci meu PIN
                    </button>

                    {{-- AVISO DE SEGURANÇA E BEM-ESTAR --}}
                    <div class="w-full bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800 rounded-xl p-4 text-left transition-colors">
                        <div class="flex items-start gap-2">
                            <i data-lucide="info" class="w-4 h-4 text-amber-600 dark:text-amber-400 mt-0.5 shrink-0"></i>
                            <div class="text-xs text-amber-800 dark:text-amber-300 space-y-2">
                                <p>
                                    <strong>Sobre a recuperação:</strong> O código será enviado para o <u>e-mail principal da conta</u> (ex: seu Gmail).
                                </p>
                                <p class="pt-2 border-t border-amber-200/60 dark:border-amber-700/50">
                                    <strong class="text-amber-700 dark:text-amber-400">❤️ Mantenha a magia:</strong>
                                    Por favor, não use esta função para espiar os votos do parceiro. Confiança é a base de tudo!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FORMULÁRIO --}}
                <div x-show="!locked" x-transition class="p-6">
                    <form action="{{ route('vows.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="bride">

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Seus Votos</label>
                            <textarea name="vows" rows="12" class="w-full rounded-xl border-gray-200 dark:border-slate-700 bg-pink-50/30 dark:bg-pink-900/10 focus:border-pink-500 focus:ring-pink-500 p-4 leading-relaxed text-gray-700 dark:text-slate-300 outline-none transition-colors" placeholder="Escreva aqui tudo o que sente...">{{ $list->vows_bride }}</textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Definir/Alterar PIN de Segurança</label>
                            <div class="flex items-center gap-2">
                                <i data-lucide="key" class="w-4 h-4 text-gray-400 dark:text-slate-500"></i>
                                <input type="text" name="pin" value="{{ $list->vows_bride_pin }}" maxlength="4" placeholder="Ex: 1234" class="w-full md:w-1/2 rounded-lg border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-pink-500 focus:border-pink-500 outline-none transition-colors">
                            </div>
                            <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">Deixe vazio para remover a senha.</p>
                        </div>

                        <button type="submit" class="w-full py-3 bg-pink-600 dark:bg-pink-700 text-white font-bold rounded-xl hover:bg-pink-700 dark:hover:bg-pink-600 transition shadow-md shadow-pink-200 dark:shadow-none">
                            Salvar Votos
                        </button>
                    </form>
                </div>
            </div>

            {{-- =========================================================
                 CARD NOIVO
                 ========================================================= --}}
            <div x-data="{
                locked: {{ $list->vows_groom_pin ? 'true' : 'false' }},
                pinInput: '',
                savedPin: '{{ $list->vows_groom_pin }}',
                unlock() {
                    if (this.pinInput === this.savedPin) { this.locked = false; }
                    else { alert('Senha incorreta!'); }
                }
            }" class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-blue-100 dark:border-blue-900/50 overflow-hidden relative transition-colors duration-300 hover:shadow-xl">

                {{-- Header --}}
                <div class="bg-blue-50 dark:bg-blue-900/20 p-6 border-b border-blue-100 dark:border-blue-900/30 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-200 dark:bg-blue-900/50 p-2 rounded-lg text-blue-700 dark:text-blue-300">
                            <i data-lucide="pen-tool" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Votos do Noivo</h3>
                    </div>
                    @if($list->vows_groom)
                        {{-- Botão Imprimir (Link direto para forçar a tela de senha) --}}
                        <a href="{{ route('vows.print', 'groom') }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 transition p-2 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-full" title="Imprimir Cartão">
                            <i data-lucide="printer" class="w-5 h-5"></i>
                        </a>
                    @endif
                </div>

                {{-- TELA DE BLOQUEIO --}}
                <div x-show="locked" class="p-8 text-center flex flex-col items-center justify-center min-h-[400px]">
                    <div class="bg-gray-100 dark:bg-slate-700 p-4 rounded-full mb-4">
                        <i data-lucide="lock" class="w-8 h-8 text-gray-400 dark:text-slate-400"></i>
                    </div>
                    <h4 class="font-bold text-gray-700 dark:text-slate-300 mb-2">Conteúdo Protegido</h4>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mb-6">Digite o PIN para ler ou editar.</p>

                    <div class="flex gap-2 justify-center mb-6">
                        <input type="password" x-model="pinInput" placeholder="PIN" maxlength="4" class="w-24 text-center text-lg font-bold tracking-widest rounded-lg border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors">
                        <button @click="unlock()" class="px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white font-bold rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition">
                            Abrir
                        </button>
                    </div>

                    {{-- BOTÃO ESQUECI A SENHA --}}
                    <button type="button" onclick="recoverPin('groom', this)" class="text-xs text-blue-500 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold underline underline-offset-2 transition mb-6">
                        Esqueci meu PIN
                    </button>

                    {{-- AVISO DE SEGURANÇA E BEM-ESTAR --}}
                    <div class="w-full bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800 rounded-xl p-4 text-left transition-colors">
                        <div class="flex items-start gap-2">
                            <i data-lucide="info" class="w-4 h-4 text-amber-600 dark:text-amber-400 mt-0.5 shrink-0"></i>
                            <div class="text-xs text-amber-800 dark:text-amber-300 space-y-2">
                                <p>
                                    <strong>Sobre a recuperação:</strong> O código será enviado para o <u>e-mail principal da conta</u> (ex: seu Gmail).
                                </p>
                                <p class="pt-2 border-t border-amber-200/60 dark:border-amber-700/50">
                                    <strong class="text-amber-700 dark:text-amber-400">❤️ Mantenha a magia:</strong>
                                    Por favor, não use esta função para espiar os votos do parceiro. Confiança é a base de tudo!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FORMULÁRIO --}}
                <div x-show="!locked" x-transition class="p-6">
                    <form action="{{ route('vows.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="groom">

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Seus Votos</label>
                            <textarea name="vows" rows="12" class="w-full rounded-xl border-gray-200 dark:border-slate-700 bg-blue-50/30 dark:bg-blue-900/10 focus:border-blue-500 focus:ring-blue-500 p-4 leading-relaxed text-gray-700 dark:text-slate-300 outline-none transition-colors" placeholder="Escreva aqui tudo o que sente...">{{ $list->vows_groom }}</textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Definir/Alterar PIN de Segurança</label>
                            <div class="flex items-center gap-2">
                                <i data-lucide="key" class="w-4 h-4 text-gray-400 dark:text-slate-500"></i>
                                <input type="text" name="pin" value="{{ $list->vows_groom_pin }}" maxlength="4" placeholder="Ex: 1234" class="w-full md:w-1/2 rounded-lg border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors">
                            </div>
                            <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">Deixe vazio para remover a senha.</p>
                        </div>

                        <button type="submit" class="w-full py-3 bg-blue-600 dark:bg-blue-700 text-white font-bold rounded-xl hover:bg-blue-700 dark:hover:bg-blue-600 transition shadow-md shadow-blue-200 dark:shadow-none">
                            Salvar Votos
                        </button>
                    </form>
                </div>
            </div>

        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if(window.lucide) window.lucide.createIcons();
        });

        // Função para disparar o e-mail de recuperação
        function recoverPin(role, btnElement) {
            const originalText = btnElement.innerText;

            // Feedback de carregamento
            btnElement.innerText = 'Enviando código...';
            btnElement.disabled = true;
            btnElement.classList.add('opacity-50', 'cursor-not-allowed');

            fetch('{{ route("vows.send_code") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ role: role })
            })
            .then(response => {
                if(response.ok) {
                    window.location.href = '{{ url("votos/verificar") }}/' + role;
                } else {
                    throw new Error('Falha no envio');
                }
            })
            .catch(error => {
                alert('Erro ao enviar e-mail. Verifique sua conexão.');
                btnElement.innerText = originalText;
                btnElement.disabled = false;
                btnElement.classList.remove('opacity-50', 'cursor-not-allowed');
            });
        }
    </script>
</x-admin-layout>
