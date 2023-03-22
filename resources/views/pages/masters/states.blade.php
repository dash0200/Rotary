<script type="text/javascript" src="{{ url('js/transliteration-input.bundle.js') }}"></script>

<x-main-card>
    ರಾಜ್ಯಗಳು
    <div class="w-full bg-gray-200" style="height: 1px;"></div>

    <div class="flex justify-around">
        <div class="w-1/4 border p-4">
            <form action="{{ route('master.addState') }}" method="post">
                <div>
                    <x-label value="ರಾಜ್ಯದ ಹೆಸರು" />
                    <x-input type="text" id="kanstate" name="state" />
                    <x-button-primary value="ಸೇರಿಸಿ" />
                </div>
            </form>
        </div>

        <div class="w-1/4 border p-4">
            <form action="{{ route('master.addDist') }}" method="post">
                @csrf
                <div>
                    <x-label value="ರಾಜ್ಯವನ್ನು ಆಯ್ಕೆಮಾಡಿ" />
                    <select name="state" id="state" required
                        class="{{ $errors->has('state') ? 'is-invalid' : '' }}">
                        <option value="">ರಾಜ್ಯವನ್ನು ಆಯ್ಕೆಮಾಡಿ</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                    <x-label value="ಜಿಲ್ಲೆಯ ಹೆಸರು" />
                    <x-input type="text" id="kandist" name="dist" required
                        class="{{ $errors->has('state') ? 'is-invalid' : '' }}" />
                    <x-button-primary value="ಸೇರಿಸಿ" />
                </div>
            </form>
        </div>

        <div class="w-1/4 border p-4">
            <form action="{{ route('master.addSub') }}" method="post">
                @csrf
                <div>
                    <x-label value="ಜಿಲ್ಲೆ ಆಯ್ಕೆಮಾಡಿ" />
                    <select name="dist" id="dist" required>
                        <option value="">ಜಿಲ್ಲೆ ಆಯ್ಕೆಮಾಡಿ</option>
                        @foreach ($dists as $dist)
                            <option value="{{ $dist->id }}">{{ $dist->name }}</option>
                        @endforeach
                    </select>
                    <x-label value="ಉಪ_ಜಿಲ್ಲೆಯ ಹೆಸರು" />
                    <x-input type="text" id="kansub" name="sub" required />
                    <x-button-primary value="ಸೇರಿಸಿ" />
                </div>
            </form>
        </div>
    </div>
</x-main-card>

<script>
    $("#state").select2()
    $("#dist").select2()

    enableTransliteration(document.getElementById('kanstate'), 'kn')
    enableTransliteration(document.getElementById('kandist'), 'kn')
    enableTransliteration(document.getElementById('kansub'), 'kn')
</script>
