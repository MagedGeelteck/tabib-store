@foreach ($categories as $category)
    <li @if ($category->activeChildren->count()) class="menu-item-has-children has-mega-menu" @endif>
        <a href="/catid/{{$category->id}}">
            @if ($category->getMetaData('icon_image', true))
                <img src="{{ RvMedia::getImageUrl($category->getMetaData('icon_image', true)) }}" alt="{{ $category->name }}" width="18" height="18">
            @elseif ($category->getMetaData('icon', true))
                <i class="{{ $category->getMetaData('icon', true) }}"></i>
            @endif
            <span class="ms-1">{!! BaseHelper::clean($category->name) !!}</span>
            @if ($category->activeChildren->count())
                <span class="sub-toggle">
                    <span class="svg-icon">
                        <i class="fa fa-chevron-down" style="font-size:16px;"></i>
                    </span>
                </span>
            @endif
        </a>
        @if ($category->activeChildren->count())
            <div class="mega-menu" @if ($category->activeChildren->count() == 1) style="min-width: 250px;" @endif>
                @foreach($category->activeChildren as $childCategory)
                    <div class="mega-menu__column">
                        @if ($childCategory->activeChildren->count())
                            <a href="{{ $childCategory->url }}">
                                <h4 style="font-size:16px;">{{ $childCategory->name }}</h4>
                                <span class="sub-toggle">
                                    <span class="svg-icon">
                                       <i class="fa fa-chevron-down" style="font-size:16px;"></i>

                                    </span>
                                </span>
                            </a>
                            <ul class="mega-menu__list">
                                @foreach($childCategory->activeChildren as $item)
                                    <li><a href="/catid/{{$item->id}}" style="font-size:14px;">{{ $item->name }}</a></li>
                                @endforeach
                            </ul>
                        @else
                            <a href="/catid/{{ $childCategory->id }}" style="font-size:16px;" class="pt-1">{{ $childCategory->name }}</a>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </li>
@endforeach
