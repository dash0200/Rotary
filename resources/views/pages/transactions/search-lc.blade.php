<x-main-card>
    <h1>
        Edit Student Info
    </h1>
    <div class="w-full bg-gray-200" style="height: 1px;"></div>

    <div class="flex flex-col items-center mt-6">

       <div class="flex space-x-2 items-center">
         <div>
             <x-label value="Student Name" />
             <x-input type="text" id="name" name="name" placeholder="Student Name" />
         </div>
        
         <div>
             <x-label value="Admission Year" />
             <select name="ac_year" id="year" class="w-full" required>
                 <option value="">Academic Year</option>
                 @foreach ($years as $year)
                     <option value="{{$year->id}}">{{ $year->year }}</option>
                 @endforeach
             </select> 
         </div>
       </div>

       <x-button-primary value="GET" onclick="getByNameYear()" />
        
    </div>
</x-main-card>

<script>
    $("#year").select2();
</script>