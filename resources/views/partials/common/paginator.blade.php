@php
//dd($results);
@endphp
@if($results->hasPages() && count($results->items()) <= App\AdipUtils\Constants::RESULTS_PER_PAGE )
@php
$c=$results->currentPage();
$fn=$results->lastPage()>5?$results->currentPage()+2:$results->lastPage();
$in=$fn-5<=0?1:$c-2;
@endphp
<nav class="mt-5" aria-label="Page navigation example pt-5">
<ul class="pagination justify-content-center">
	<li class="page-item{!! $results->onFirstPage()?' disabled':'' !!}">
		<a class="page-link page-link-custom" href="{{$results->url(1)}}" tabindex="-1"{!! $results->onFirstPage()?' aria-disabled="true"':'' !!} aria-label="Ir a la primera página" title="Primera página">
			<img src="{{ asset('images/arrow_first.svg') }}" alt="">
		</a>
	</li>
	<li class="page-item{!! $results->onFirstPage()?' disabled':'' !!}">
		<a class="page-link page-link-custom" href="{{$results->previousPageUrl()}}" tabindex="-1"{!! $results->onFirstPage()?' aria-disabled="true"':'' !!} aria-label="Página anterior" title="Página anterior">
			<img src="{{ asset('images/arrow_prev.svg') }}" alt="">
		</a>
	</li>
    @for($l=$in;$l<=$fn;$l++)
        @if($l<=$results->lastPage())
        <li class="page-item">
			@php
			if($results->currentPage() == $l){
				$style = ' curpage';
			}else{
				$style = '';
			}
			@endphp
			<a class="page-link page-link-custom{{ $style }}" href="{{$results->url($l)}}">{{ $l }}</a>
            
        </li>
        @endif
    @endfor
	<li class="page-item{!! $results->hasMorePages()?'':' disabled' !!}">
		<a class="page-link page-link-custom" href="{{ $results->hasMorePages()?$results->nextPageUrl():'' }}"{!! $results->hasMorePages()?'':' aria-disabled="true"' !!} aria-label="Página siguiente" title="Siguiente página">
			<img src="{{ asset('images/arrow_next.svg') }}" alt="">
		</a>
	</li>
	<li class="page-item{!! $results->hasMorePages()?'':' disabled' !!}">
		<a class="page-link page-link-custom" href="{{$results->url($results->lastPage())}}" tabindex="-1"{!! $results->hasMorePages()?'':' aria-disabled="true"' !!} aria-label="Ir a la última página" title="Última página">
			<img src="{{ asset('images/arrow_last.svg') }}" alt="*">
		</a>
	</li>
</ul>
</nav>
@endif