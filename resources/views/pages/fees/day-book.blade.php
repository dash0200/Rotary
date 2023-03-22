<x-main-card>
    ದಿನದ ಪುಸ್ತಕ
    <div class="w-full bg-gray-200" style="height: 1px;"></div>

    <form action="{{route('fees.daybookSubmit')}}">
        <div class="flex justify-center items-center space-x-11">
            <div>
                <select name="section" id="section">
                    <option value="1">ಪ್ರಾಥಮಿಕ</option>
                    <option value="2">ಪ್ರೌಡ</option>
                </select>
            </div>
        
            <div>
                <x-input type="date" name="date" id="date"/>
            </div>
            <div>
                <x-button-primary value="ಸಲ್ಲಿಸು" />
            </div>
        </div>
    </form>
</x-main-card>

<script>
    $("#section").select2();
</script>