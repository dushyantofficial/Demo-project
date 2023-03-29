<footer id="footer" class="footer">
    @php
        $year = \Carbon\Carbon::now()->format('Y')
    @endphp

    <div class="copyright">
        @if(\Illuminate\Support\Facades\Auth::user()->lang == 'guj')
        {{gujarati_number($year-1)}}-{{gujarati_number($year)}}
        @else
            {{$year-1}}-{{$year}}
        @endif
        &copy; Copyright <strong><span>Dairy-Report</span></strong>. All Rights Reserved
    </div>
</footer>
