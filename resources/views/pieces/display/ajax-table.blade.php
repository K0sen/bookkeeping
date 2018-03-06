<div class="accounting-table">

    @if ($table)
        <div class="date-row">
            @foreach ($period as $date)
                <div class="date-row__date">{{ $date->format('d/m/y') }}&nbsp;</div>
            @endforeach
        </div>

        @foreach ($table as $categoryName => $groups )
            <div class="category">
                <div class="category__name category-name">{{ $categoryName }}</div>

                @foreach ($groups as $groupName => $articles )
                    @if ($groupName == '$sum')
                        <div class="category__sum sum">sum: {{ $groups['$sum'] }}</div>
                        @continue
                    @endif

                    <div class="group">
                        <div class="group__name group-name">{{ $groupName }}</div>

                        @foreach ($articles as $articleName => $transactions )
                            @if ($articleName == '$sum')
                                <div class="group__sum sum">sum: {{ $articles['$sum'] }}</div>
                                @continue
                            @endif

                            <div class="article">
                                <div class="article__name">{{ $articleName }}</div>

                                @foreach ($transactions as $key => $transaction )
                                    @if ($key === '$sum')
                                        <div class="article__sum sum">sum: {{ $transactions['$sum'] }}</div>
                                        @continue
                                    @endif

                                    <div class="transactions">
                                        @foreach ($transaction as $date => $sum )
                                            <div data-date="{{ $date }}" class="transaction">{{ $sum }}</div>
                                        @endforeach
                                    </div>

                                @endforeach
                            </div>
                        @endforeach

                    </div>
                @endforeach

            </div>
        @endforeach
    @else
        <img src="{{ asset('images/nothing.png') }}" alt="nothing">
    @endif

</div>