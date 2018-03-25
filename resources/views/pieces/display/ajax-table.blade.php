<div class="accounting-table">

    @if ($table)
        <table class="table">
            <thead>
            <tr>
                <th>&nbsp;</th>
            @foreach ($period as $date)
                <th class="date-row__date">{{ $date->format('d/m/y') }}&nbsp;</th>
            @endforeach
            </tr>
            </thead>
            <tbody>

            @foreach ($table as $categoryName => $category )

            <tr>
                <td>
                    <div class="category">
                        <div class="category__name category-name">{{ $categoryName }}</div>
                        <div class="category__sum">sum: {{ $category['category_sum'] }}</div>
                    </div>
                </td>
                @foreach ($period as $date)
                <td>&nbsp;</td>
                @endforeach
            </tr>

                @foreach ($category['groups'] as $groupName => $group)
                <tr>
                    <td>
                        <div class="group">
                            <div class="group__name group-name">{{ $groupName }}</div>
                            <div class="group__sum">sum: {{ $group['group_sum'] }}</div>
                        </div>
                    </td>
                    @foreach ($period as $date)
                    <td>&nbsp;</td>
                    @endforeach
                </tr>

                    @foreach ($group['articles'] as $articleName => $article)
                    <tr>
                        <td>
                            <div class="article">
                                <div class="article__name artile-name">{{ $articleName }}</div>
                                <div class="article__sum">sum: {{ $article['article_sum'] }}</div>
                            </div>
                        </td>
                        @foreach ($period as $date)
                            @if (isset($article['transactions'][$date->format('Y-m-d')]))
                            <td>{{ $article['transactions'][$date->format('Y-m-d')] }}</td>
                            @else
                            <td>&nbsp;</td>
                            @endif
                        @endforeach
                    </tr>
                    @endforeach

                @endforeach

            @endforeach
            </tbody>
        </table>

    @else
        <img src="{{ asset('images/nothing.png') }}" alt="nothing">
    @endif

</div>