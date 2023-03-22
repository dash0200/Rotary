<x-main-card>
    ಪಾತ್ರವರ್ಗದ ವಿವರಗಳು
<div class="w-full bg-gray-200" style="height: 1px;"></div>

<form action="{{route('report.catAssocCast')}}" method="post">
    @csrf
<div>
    <select name="cat" id="cat">
        @foreach($cats as $cat)
        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
    </select>
    <x-button-primary value="ಸಲ್ಲಿಸು"/>
</div>
</form>
</x-main-card>

<script>
    $("#cat").select2()

    $(document).ready(function () {
        $("#cat").append(
            `
            <option value="all" selected>ALL</option>
            `
        )
    });
</script>