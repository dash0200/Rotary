<x-main-card>
    New Admission
    <div class="w-full bg-gray-200" style="height: 1px;"></div>

    <div class="flex flex-col">
        <div class="flex space-x-3">
            <div class="flex flex-col">
                <div class="m-2">
                    <x-label value="SST" />
                    <x-input type="text" name="sst" placeholder="SST" />
                </div>
                <div class="m-2">
                    <x-label value="Admission Date" />
                    <x-input type="date" name="admDate" placeholder="Pick Date" />
                </div>
                <div class="m-2">
                    <x-label value="Classes"/>
                    <select name="class" id="class">
                        <option value="">Select Class</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex flex-col">
                <div class="m-2">
                    <x-label value="Student Name" />
                    <x-input type="text" placeholder="First Name" required/>
                </div>
                <div class="m-2">
                    <x-label value="Father Name" />
                    <x-input type="text" placeholder="Father Name" />
                </div>
                <div class="m-2">
                    <x-label value="Mother Name" />
                    <x-input type="text" placeholder="Mother Name" />
                </div>
                <div class="m-2">
                    <x-label value="Sur Name" />
                    <x-input type="text" placeholder="Sur Name" />
                </div>
            </div>
            
            <div class="flex flex-col">
                <div class="m-2">
                    <x-label value="City"/>
                    <select name="city" id="city">
                        <option value="">Select Class</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="m-2">
                    <x-label value="Phone Number" />
                    <x-input type="text" placeholder="Phone" />
                </div>
                <div class="m-2">
                    <x-label value="Mobile Number" />
                    <x-input type="text" placeholder="Mobile" />
                </div>
                <div class="m-2">
                    <x-label value="Date of Birth" />
                    <x-input type="date" placeholder="DOB" />
                </div>
            </div>
        </div>
        
        <div class="flex space-x-3">
            <div class="flex flex-col"></div>
            <div class="flex flex-col"></div>
            <div class="flex flex-col"></div>
        </div>
    </div>
   
</x-main-card>

<script>
    $("#class").select2();
    $("#city").select2();
</script>
