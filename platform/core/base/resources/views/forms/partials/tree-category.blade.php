<ul class="{{ $className ?? '' }}">
    @foreach ($categories->where('parent_id', $parent_id ?? 0) as $category)
        @php
            $totalChildren = $categories->where('parent_id', $category->id)->count()
        @endphp
        <li class="folder-root closed" data-id="{{ $category->id }}">
            <a href="{{ $canEdit && $editRoute ? route($editRoute, $category->id) : '' }}" class="fetch-data category-name" style="color:#000!important;">
                @if ($totalChildren)
                    <i class="far fa-folder"></i>
                    
                @else
                    <i class="far fa-file"></i>
                @endif
                
                <button class="btn btn-dark" style="color:#000!important; background-color: #f8f8f8 !important; font-size:17px; border: 0.5px solid black; border-radius: 10px !important;">{{ $category->name }} {!! $category->badge_with_count !!}</button>
                
            </a>
            @if ($category->url)
                <a hidden href="{{ $category->url }}"
                    target="_blank"
                    class="text-info"
                    data-bs-toggle="tooltip"
                    data-bs-original-title="{{ trans('core/base::forms.view_new_tab') }}">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            @endif
            @if ($canDelete)
                <a href="#"
                    class="btn btn-icon btn-danger deleteDialog"
                    data-section="{{ route($deleteRoute, $category->id) }}"
                    role="button"
                    data-bs-toggle="tooltip"
                    data-bs-original-title="{{ trans('core/table::table.delete') }}">
                    <i class="fa fa-trash"></i>
                </a>
            @endif
            @if ($totalChildren)
                <i class="far fa-minus-square file-opener-i"></i>
                @include('core/base::forms.partials.tree-category', ['parent_id' => $category->id, 'className' => ''])
            @endif
        </li>
    @endforeach
</ul>
